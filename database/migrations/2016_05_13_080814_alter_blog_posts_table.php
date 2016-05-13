<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog-posts', function ($table) {
            $table->string('subtitle')->after('title');
            $table->renameColumn('content', 'content_raw');
            $table->text('content_html')->after('content');
            $table->string('page_image')->after('content_html');
            $table->string('meta_description')->after('page_image');
            $table->boolean('is_draft')->after('meta_description');
            $table->string('layout')->after('is_draft')
                  ->default('blog.layouts.post');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog-posts', function ($table) {
            $table->dropColumn('subtitle')->after('title');
            $table->renameColumn('content_raw', 'content');
            $table->dropColumn('content_html')->after('content');
            $table->dropColumn('page_image');
            $table->dropColumn('meta_description');
            $table->dropColumn('is_draft');
        });
    }
}
