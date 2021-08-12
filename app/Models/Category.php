<?php

namespace App\Models;

use App\Models\Info\CategoryAttr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        CategoryAttr::CATEGORY_NAME,
        CategoryAttr::ICON_IMAGE
    ];
}
