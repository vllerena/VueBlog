<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Info\BlogAttr;
use App\Models\Info\UserAttr;

class CreateBlogsTable extends Migration
{
    private const BLOGS_TABLE = BlogAttr::TABLE_NAME;

    public function up()
    {
        Schema::create(self::BLOGS_TABLE, function (Blueprint $table) {
            $table->id(BlogAttr::ID);
            $table->string(BlogAttr::TITLE);
            $table->string(BlogAttr::POST);
            $table->string(BlogAttr::SLUG)->unique();
            $table->foreignId(BlogAttr::USER_ID)
                ->unique()
                ->constrained(UserAttr::TABLE_NAME, UserAttr::ID)
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->string(BlogAttr::FEATURED_IMAGE);
            $table->string(BlogAttr::META_DESCRIPTION);
            $table->integer(BlogAttr::VIEWS)->default(0);
            $table->string(BlogAttr::POST_EXCERPT);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::BLOGS_TABLE);
    }
}
