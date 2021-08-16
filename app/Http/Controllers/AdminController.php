<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Info\CategoryAttr;
use App\Models\Info\TagAttr;
use App\Models\Info\UserAttr;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        Log::debug(Auth::user());
//        if (!Auth::check() && $request->path() != 'login') {
//            return redirect('/login');
//        }
//        if (!Auth::check() && $request->path() == 'login') {
//            return view('welcome');
//        }
//        $user = Auth::user();
//        if ($user->userType == 'User') {
//            return redirect('/login');
//        }
//        if ($request->path() == 'login') {
//            return redirect('/');
//        }
        return view('welcome');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function uploadIcon(Request $request)
    {
        $this->validate($request, [
            'file' => 'required | image | mimes:jpeg,bmp,png'
        ]);
        $iconName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $iconName);
        return $iconName;
    }

    public function deleteIcon(Request $request)
    {
        $fileName = $request->iconName;
        $this->deleteFileFromServer($fileName);
        return 'done';
    }

    public function deleteFileFromServer($fileName)
    {
        $filePath = public_path().$fileName;
        if (file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
           UserAttr::EMAIL => 'required | email',
           UserAttr::PASSWORD => 'required | min:6'
        ]);

        if (Auth::attempt([UserAttr::EMAIL => $request->email, UserAttr::PASSWORD => $request->password])){
            $user = Auth::user();
//            if ($user->userType === 'User'){
//                Auth::logout();
//                return response()->json([
//                    'msg' => 'Incorrect login details'
//                ], 401);
//            };
            return response()->json([
                'msg' => 'Welcome!',
                'user' => $user
            ]);
        } else {
            return response()->json([
                'msg' => 'Incorrect login details'
            ], 401);
        }
    }

    public function listTag()
    {
        return Tag::orderBy(TagAttr::ID, 'desc')->get();
    }

    public function addTag(Request $request)
    {
        $this->validate($request, [
            TagAttr::TAG_NAME => 'required'
        ]);
        return Tag::create([
            TagAttr::TAG_NAME => $request->tagName
        ]);
    }

    public function editTag(Request $request)
    {
        $this->validate($request, [
            TagAttr::ID => 'required',
            TagAttr::TAG_NAME => 'required'
        ]);
        return Tag::where(TagAttr::ID, $request->id)->update([
            TagAttr::TAG_NAME => $request->tagName
        ]);
    }

    public function deleteTag(Request $request)
    {
        return Tag::where(TagAttr::ID, $request->id)->delete();
    }

    public function listCategory()
    {
        return Category::orderBy(CategoryAttr::ID, 'desc')->get();
    }

    public function addCategory(Request $request)
    {
        $this->validate($request, [
            CategoryAttr::CATEGORY_NAME => 'required',
            CategoryAttr::ICON_IMAGE => 'required',
        ]);
        return Category::create([
            CategoryAttr::CATEGORY_NAME => $request->categoryName,
            CategoryAttr::ICON_IMAGE => $request->iconImage,
        ]);
    }

    public function editCategory(Request $request)
    {
        $this->validate($request, [
            CategoryAttr::CATEGORY_NAME => 'required',
            CategoryAttr::ICON_IMAGE => 'nullable', 'image'
        ]);
        return Category::where(CategoryAttr::ID, $request->id)->update([
            CategoryAttr::CATEGORY_NAME => $request->categoryName,
            CategoryAttr::ICON_IMAGE => $request->iconImage
        ]);
    }

    public function deleteCategory(Request $request)
    {
        return Category::where(CategoryAttr::ID, $request->id)->delete();
    }

    public function listUser()
    {
        return User::where(UserAttr::USER_TYPE, '!=', 'User')->orderBy(UserAttr::ID, 'desc')->get();
    }

    public function addUser(Request $request)
    {
        $this->validate($request, [
            UserAttr::FULLNAME => 'required',
            UserAttr::EMAIL => 'required | email | unique:users',
            UserAttr::PASSWORD => 'required | min:6',
            UserAttr::USER_TYPE => 'required',
        ]);
        return User::create([
            UserAttr::FULLNAME => $request->fullName,
            UserAttr::EMAIL => $request->email,
            UserAttr::PASSWORD => bcrypt($request->password),
            UserAttr::USER_TYPE => $request->userType,
        ]);
    }

    public function editUser(Request $request)
    {
        $this->validate($request, [
            UserAttr::FULLNAME => 'required',
            UserAttr::EMAIL => "bail | required | email | unique:users,email,$request->id",
            UserAttr::PASSWORD => 'nullable | min:6',
            UserAttr::USER_TYPE => 'required',
        ]);

        $data = [
          UserAttr::FULLNAME => $request->fullName,
          UserAttr::EMAIL => $request->email,
          UserAttr::USER_TYPE => $request->userType,
        ];

        if ($request->password){
            $data[UserAttr::PASSWORD] = bcrypt($request->password);
        }

        return User::where(UserAttr::ID, $request->id)->update($data);
    }

    public function deleteUser(Request $request)
    {
        return User::where(UserAttr::ID, $request->id)->delete();
    }
}
