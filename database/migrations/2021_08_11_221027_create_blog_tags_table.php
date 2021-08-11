<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Info\BlogTagAttr;
use App\Models\Info\TagAttr;
use App\Models\Info\BlogAttr;

class CreateBlogTagsTable extends Migration
{
    private const BLOG_TAGS_TABLE = BlogTagAttr::TABLE_NAME;

    public function up()
    {
        Schema::create(self::BLOG_TAGS_TABLE, function (Blueprint $table) {
            $table->id(BlogTagAttr::ID);
            $table->foreignId(BlogTagAttr::TAG_ID)
                ->unique()
                ->constrained(TagAttr::TABLE_NAME, TagAttr::ID)
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->foreignId(BlogTagAttr::BLOG_ID)
                ->unique()
                ->constrained(BlogAttr::TABLE_NAME, BlogAttr::ID)
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::BLOG_TAGS_TABLE);
    }
}
