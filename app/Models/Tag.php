<?php

namespace App\Models;

use App\Models\Info\TagAttr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        TagAttr::TAG_NAME
    ];
}
