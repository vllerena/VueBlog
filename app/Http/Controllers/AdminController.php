<?php

namespace App\Http\Controllers;

use App\Models\Info\TagAttr;
use App\Models\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{
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
}
