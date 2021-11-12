<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsiteNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_navigations', function (Blueprint $table) {
            $table->id();
            $table->string('title', 128);
            $table->string('link', 128);
            $table->string('icon', 128)->nullable();
            $table->integer('position');
            $table->foreignId('group_id');
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('permission_id');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('group_id')->on('website_navigation_groups')->references('id')->onUpdate('cascade');
            $table->foreign('parent_id')->on('website_navigations')->references('id');
            $table->foreign('permission_id')->on('permissions')->references('id')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_navigations');
    }
}
