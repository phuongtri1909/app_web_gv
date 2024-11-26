<?php

namespace App\Http\Controllers;

use UniSharp\LaravelFilemanager\Controllers\UploadController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use UniSharp\LaravelFilemanager\Lfm;
use Intervention\Image\Facades\Image; // Import Intervention Image
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
class CustomUploadController extends UploadController
{
    protected $errors;

    public function __construct()
    {
        parent::__construct();
        $this->errors = [];
    }

    /**
     * Upload files
     *
     * @param void
     *
     * @return JsonResponse
     */
    public function upload()
    {
        $uploaded_files = request()->file('upload');
        $error_bag = [];
        $new_filename = null;

        foreach (is_array($uploaded_files) ? $uploaded_files : [$uploaded_files] as $file) {
            try {
                // Validate the uploaded file
                $this->lfm->validateUploadedFile($file);

                // Check MIME type and set folder
                $mime_type = $file->getMimeType();
                $folder = '';

                if (in_array($mime_type, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                    $folder = 'photos'; 
                } elseif (in_array($mime_type, ['application/pdf', 'text/plain'])) {
                    $folder = 'files'; 
                } else {
                    throw new \Exception("Unsupported file type: $mime_type");
                }

                if (in_array($mime_type, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                    $webp_filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
                    
                    $image = Image::make($file->getRealPath());
                    $image->encode('webp', 75);

                    $temp_path = sys_get_temp_dir() . '/' . $webp_filename;
                    $image->save($temp_path);
                    
                    $uploadedFile = new UploadedFile($temp_path, $webp_filename, 'image/webp', null, true);

                    $new_filename = $this->lfm->upload($uploadedFile, $folder, function ($file) use ($folder) {
                        return $folder . '/' . basename($file);
                    });
                    unlink($temp_path);
                } else {
                    $new_filename = $this->lfm->upload($file, $folder);
                }

            } catch (\Exception $e) {
                Log::error($e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
                array_push($error_bag, $e->getMessage());
            } catch (\Error $e) {
                Log::error($e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
                array_push($error_bag, 'Some error occurred during uploading.');
            }
        }
        if (is_array($uploaded_files)) {
            $response = count($error_bag) > 0 ? $error_bag : parent::$success_response;
        } else {
            if (is_null($new_filename)) {
                $response = [
                    'error' => ['message' => $error_bag[0]]
                ];
            } else {
                $url = $this->lfm->setName($new_filename)->url();

                $response = [
                    'url' => $url,
                    'uploaded' => $url
                ];
            }
        }

        return response()->json($response);
    }

}

