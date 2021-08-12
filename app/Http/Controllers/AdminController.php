<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Info\CategoryAttr;
use App\Models\Info\TagAttr;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
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
}
