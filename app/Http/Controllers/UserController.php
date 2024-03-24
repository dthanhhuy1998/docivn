<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Hash;
use Auth;

// Model
use App\Models\User;
use App\Models\UserGroup;
use App\Models\Config;

class UserController extends Controller
{
    protected $configModel = '';

    public function __construct() {
        $this->configModel = new Config();
    }

    public function getAdminLogin() {
        $favicon = asset('storage/app/'.$this->configModel->getConfig('favicon'));

        $headingTitle = heading('Đăng nhập');

        return view('admin.pages.login',
            compact('headingTitle', 'favicon')
        );
    }

    public function postAdminLogin(Request $request) {
        $request->validate([
            'username'          => 'required|min:3|max:50',
            'user_password'     => 'required|min:6|max:50',
        ],[
            'username.required'         => 'Vui lòng nhập tên tài khoản!',
            'username.min'              => 'Tên tài khoản phải từ 3 ký tự!',
            'username.max'              => 'Tên tài khoản tối đa 50 ký tự!',
            'user_password.required'    => 'Vui lòng nhập mật khẩu!',
            'user_password.min'         => 'Mật khẩu phải từ 6 ký tự!',
            'user_password.max'         => 'Mật khẩu tối đa 50 ký tự!',
        ]);

        if(Auth::attempt(['username' => $request->username, 'password' => $request->user_password, 'status' => 1])) {
            return redirect()->route('admin.index');
        } else {
            return redirect()->back()->with('error_msg', 'Tên tài khoản hoặc mật khẩu không đúng!');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('getAdminLogin');
    }

    public function getList() {
        $users = User::where('id', '<>', 1)->get();

        $headingTitle = heading('Danh sách tài khoản');
        $actionTitle = 'Danh sách tài khoản';

        return view('admin.pages.user.list',
            compact('headingTitle', 'actionTitle', 'users')
        );
    }

    public function getAdd() {
        $userGroups = UserGroup::all();

        $headingTitle = heading('Tạo tài khoản mới');
        $actionTitle = 'Tạo tài khoản mới';

        return view('admin.pages.user.add',
            compact('headingTitle', 'actionTitle', 'userGroups')
        );
    }

    public function postAdd(Request $request) {
        $validated = $request->validate([
            'username'          => 'required|min:3|max:50|unique:users,username',
            'firstname'         => 'required|max:100',
            'lastname'          => 'required|max:100',
            'user_password'     => 'required|min:6|max:50',
            'password_confirm'  => 'same:user_password'
        ],[
            'username.required'         => 'Tên tài khoản không được bỏ trống!',
            'username.min'              => 'Tên tài khoản phải từ 3 ký tự!',
            'username.max'              => 'Tên tài khoản tối đa 50 ký tự!',
            'username.unique'           => 'Tên tài khoản đã được sử dụng!',
            'firstname.required'        => 'Họ không được bỏ trống!',
            'firstname.max'             => 'Họ tối đa 100 ký tự!',
            'lastname.required'         => 'Tên không được bỏ trống!',
            'lastname.max'              => 'Tên tối đa 100 ký tự!',
            'user_password.required'    => 'Mật khẩu không được bỏ trống!',
            'user_password.min'         => 'Mật khẩu phải từ 6 ký tự!',
            'user_password.max'         => 'Mật khẩu tối đa 50 ký tự!',
            'password_confirm.same'     => 'Mật khẩu nhập lại không trùng nhau!'
        ]);

        $file_path = '';
        if($request->hasFile('file')) {
            $file_path = Storage::putFile('uploads/user', $request->file('file'));
        }

        $user = new User();
        $user->user_group_id = $request->user_group_id;
        $user->username = $request->username;
        $user->password = Hash::make($request->user_password);
        $user->email = $request->user_email;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->image = $file_path;
        $user->status = $request->status;
        $user->save();

        return redirect()->route('admin.user.getList')->with('success_msg', 'Bạn đã tạo tài khoản thành công');
    }

    public function getEdit($userId) {
        $userGroups = UserGroup::all();
        $user = User::findOrFail($userId);

        $headingTitle = heading('Chỉnh sửa');
        $actionTitle = 'Chỉnh sửa';

        return view('admin.pages.user.edit',
            compact('headingTitle', 'actionTitle', 'userGroups', 'user')
        );
    }

    public function postEdit(Request $request) {
        $validated = $request->validate([
            'username'          => 'required|min:3|max:50|unique:users,username,' . $request->id,
            'firstname'         => 'required|max:100',
            'lastname'          => 'required|max:100'
        ],[
            'username.required'         => 'Tên tài khoản không được bỏ trống!',
            'username.min'              => 'Tên tài khoản phải từ 3 ký tự!',
            'username.max'              => 'Tên tài khoản tối đa 50 ký tự!',
            'username.unique'           => 'Tên tài khoản đã được sử dụng!',
            'firstname.required'        => 'Họ không được bỏ trống!',
            'firstname.max'             => 'Họ tối đa 100 ký tự!',
            'lastname.required'         => 'Tên không được bỏ trống!',
            'lastname.max'              => 'Tên tối đa 100 ký tự!'
        ]);

        $user = User::findOrFail($request->id);

        if($request->hasFile('file')) {
            Storage::delete($user->image);
            $file_path = Storage::putFile('uploads/user', $request->file('file'));
        } else {
            $file_path = $user->image;
        }

        $user->user_group_id = $request->user_group_id;
        $user->username = $request->username;
        $user->email = $request->user_email;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->image = $file_path;
        $user->status = $request->status;
        $user->save();

        return redirect()->route('admin.user.getList')->with('success_msg', 'Bạn đã chỉnh sửa tài khoản thành công');
    }

    public function getDelete($userId) {

        $user = User::findOrFail($userId);

        if(!empty($user->image)) {
            Storage::delete($user->image);
        }

        if($user->id != Auth::user()->id) {
            $user->delete();
            return redirect()->route('admin.user.getList')->with('success_msg', 'Đã xóa tài khoản thành công');
        } else {
            return redirect()->route('admin.user.getList')->with('warning_msg', 'Tài khoản này đang được sử dụng. Không thể xóa!');
        }
    }

    public function getResetPass($userId) {
        $user = User::findOrFail($userId);

        $headingTitle = heading('Đổi mật khẩu');
        $titlePage = 'Đổi mật khẩu';

        return view('admin.pages.user.reset-pass',
            compact('headingTitle', 'titlePage', 'user')
        );
    }

    public function postResetPass(Request $request) {
        $validated = $request->validate([
            'user_password'     => 'required|min:6|max:50',
            'password_confirm'  => 'same:user_password'
        ],[
            'user_password.required'    => 'Mật khẩu không được bỏ trống!',
            'user_password.min'         => 'Mật khẩu phải từ 6 ký tự!',
            'user_password.max'         => 'Mật khẩu tối đa 50 ký tự!',
            'password_confirm.same'     => 'Mật khẩu nhập lại không trùng nhau!'
        ]);

        $user = User::findOrFail($request->id);
        $user->password = Hash::make($request->user_password);
        $user->save();

        Auth::logout();

        return redirect()->route('getAdminLogin')->with('success_msg', 'Bạn đã đổi mật khẩu thành công. Vui lòng đăng nhập lại');
    }
}



