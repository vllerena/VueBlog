<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Info\CategoryAttr;

class CreateCategoriesTable extends Migration
{
    private const CATEGORIES_TABLE = CategoryAttr::TABLE_NAME;

    public function up()
    {
        Schema::create(self::CATEGORIES_TABLE, function (Blueprint $table) {
            $table->id(CategoryAttr::ID);
            $table->string(CategoryAttr::CATEGORY_NAME);
            $table->string(CategoryAttr::ICON_IMAGE);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::CATEGORIES_TABLE);
    }
}
