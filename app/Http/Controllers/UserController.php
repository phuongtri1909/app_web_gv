<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\BusinessMember;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchStatus = $request->input('search-status');
        $searchRole = $request->input('search-role');

        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('username', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('businessMember', function ($query) use ($search) {
                            $query->where('business_code', 'like', "%{$search}%");
                        });
                });
            })
            ->when($searchStatus, function ($query, $searchStatus) {
                return $query->where('status', $searchStatus);
            })
            ->when($searchRole, function ($query, $searchRole) {
                return $query->where('role', $searchRole);
            })
            ->latest()
            ->paginate(20);

        return view('admin.pages.users.index', compact('users'));
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['error' => 'Tài khoản này không tồn tại']);
        }

        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => 'Thay đổi trạng thái thành công']);
    }

    public function create()
    {
        $businessMembers = BusinessMember::doesntHave('user')->get();
        return view('admin.pages.users.create', compact('businessMembers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_member_id' => 'nullable|exists:business_registrations,id',
            'username' => 'required_if:business_member_id,null|unique:users,username',
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:8',
            'status' => 'required|in:active,inactive',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,wepb,svg',
        ], [
            'business_member_id.exists' => 'Doanh nghiệp/hộ kinh doanh không tồn tại.',
            'username.required_if' => 'Tài khoản không được để trống.',
            'username.unique' => 'Tài khoản đã tồn tại.',
            'full_name.required' => 'Họ tên không được để trống.',
            'full_name.string' => 'Họ tên phải là chuỗi.',
            'full_name.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.string' => 'Mật khẩu phải là chuỗi.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'avatar.image' => 'Ảnh phải là một tập tin hình ảnh.',
            'avatar.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, gif, webp, svg.',
        ]);

        try {

            $user = new User();

            $user->full_name = $request->full_name;
            $user->password = bcrypt($request->password);
            $user->email = $request->email;
            $user->status = $request->status;

            if ($request->hasFile('avatar')) {
                try {
                    $image = $request->file('avatar');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileName = $originalFileName . '_' . time() . '.webp';
                    $uploadPath = public_path('uploads/images/avatar/' . $folderName);

                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $image = Image::make($image->getRealPath());
                    $image->resize(225, 225)->encode('webp', 75);
                    $image->save($uploadPath . '/' . $fileName);

                    $image_path = 'uploads/images/avatar/' . $folderName . '/' . $fileName;

                    $user->avatar = $image_path;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }

                    return redirect()->back()->with('error', 'Có lỗi xảy ra khi tải ảnh lên');
                }
            }

            if ($request->filled('business_member_id')) {
                $businessMember = BusinessMember::find($request->business_member_id);



                $existingUser = User::where('business_member_id', $request->business_member_id)->first();
                if ($existingUser) {
                    return redirect()->back()->with('error', 'Doanh nghiệp/hộ kinh doanh này đã có tài khoản');
                }

                $user->business_member_id = $businessMember->id;
                $user->username = $businessMember->business_code;
            } else {
                $user->username = $request->username;
                $user->role = 'admin';
            }

            $user->save();

            return redirect()->route('users.index')->with('success', 'Tạo tài khoản thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo tài khoản');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Tài khoản này không tồn tại');
        }
        return view('admin.pages.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'status' => 'required|in:active,inactive',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,wepb,svg',
        ], [
            'full_name.required' => 'Họ tên không được để trống.',
            'full_name.string' => 'Họ tên phải là chuỗi.',
            'full_name.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.string' => 'Mật khẩu phải là chuỗi.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'avatar.image' => 'Ảnh phải là một tập tin hình ảnh.',
            'avatar.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, gif, webp, svg.',
        ]);

        try {
            $user->full_name = $request->full_name;
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            $user->email = $request->email;
            $user->status = $request->status;

            if ($request->hasFile('avatar')) {
                try {
                    $image = $request->file('avatar');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileName = $originalFileName . '_' . time() . '.webp';
                    $uploadPath = public_path('uploads/images/avatar/' . $folderName);

                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $image = Image::make($image->getRealPath());
                    $image->resize(225, 225)->encode('webp', 75);
                    $image->save($uploadPath . '/' . $fileName);

                    $image_path = 'uploads/images/avatar/' . $folderName . '/' . $fileName;

                    // Delete the old avatar if it exists
                    if ($user->avatar && File::exists(public_path($user->avatar))) {
                        File::delete(public_path($user->avatar));
                    }

                    $user->avatar = $image_path;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }

                    return redirect()->back()->with('error', 'Có lỗi xảy ra khi tải ảnh lên');
                }
            }

            $user->save();

            return redirect()->route('users.index')->with('success', 'Cập nhật tài khoản thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật tài khoản');
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Tài khoản này không tồn tại');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Xóa tài khoản thành công');
    }
}
