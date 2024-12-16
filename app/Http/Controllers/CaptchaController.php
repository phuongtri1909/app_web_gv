<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
class CaptchaController extends Controller
{
    public function generateCaptcha()
    {
        if (ob_get_length()) {
            ob_end_clean();
        }
        $captchaCode = $this->generateRandomString(6);
        Session::put('captcha_code', $captchaCode);
        $image = imagecreatetruecolor(100, 40);
        $background = imagecolorallocate($image, 0, 0, 0);
        $textColor = imagecolorallocate($image, 255, 255, 255);              
        imagefill($image, 0, 0, $background);
        imagestring($image, 5, 25, 12, $captchaCode, $textColor);
        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
    private function generateRandomString($length = 6)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
