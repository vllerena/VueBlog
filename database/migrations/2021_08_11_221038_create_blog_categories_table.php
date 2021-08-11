<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Info\BlogCategoryAttr;
use App\Models\Info\CategoryAttr;
use App\Models\Info\BlogAttr;

class CreateBlogCategoriesTable extends Migration
{
    private const BLOG_CATEGORIES_TABLE = BlogCategoryAttr::TABLE_NAME;

    public function up()
    {
        Schema::create(self::BLOG_CATEGORIES_TABLE, function (Blueprint $table) {
            $table->id(BlogCategoryAttr::ID);
            $table->foreignId(BlogCategoryAttr::CATEGORY_ID)
                ->unique()
                ->constrained(CategoryAttr::TABLE_NAME, CategoryAttr::ID)
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->foreignId(BlogCategoryAttr::BLOG_ID)
                ->unique()
                ->constrained(BlogAttr::TABLE_NAME, BlogAttr::ID)
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::BLOG_CATEGORIES_TABLE);
    }
}
