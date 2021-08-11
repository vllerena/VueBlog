<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Info\TagAttr;

class CreateTagsTable extends Migration
{
    private const TAGS_TABLE = TagAttr::TABLE_NAME;

    public function up()
    {
        Schema::create(self::TAGS_TABLE, function (Blueprint $table) {
            $table->id(TagAttr::ID);
            $table->string(TagAttr::TAG_NAME);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::TAGS_TABLE);
    }
}
