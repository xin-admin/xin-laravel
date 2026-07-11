<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('sys_site_config_items')) {
            Schema::create('sys_site_config_items', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('key', 50)->comment('设置项标示');
                $table->string('title', 50)->comment('设置标题');
                $table->string('describe', 500)->nullable()->default('')->comment('设置项描述');
                $table->string('values', 255)->nullable()->default('')->comment('设置值');
                $table->string('type', 50)->comment('设置类型');
                $table->string('options', 500)->nullable()->comment('options配置');
                $table->string('props', 500)->nullable()->comment('props配置');
                $table->integer('group_id')->comment('分组ID');
                $table->integer('sort')->comment('排序');
                $table->timestamps();
                $table->comment('系统设置表');
                $table->unique(['key', 'group_id']);
            });
        }
        if (! Schema::hasTable('sys_site_config_group')) {
            Schema::create('sys_site_config_group', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title', 50)->comment('分组标题');
                $table->string('key', 50)->comment('分组KEY');
                $table->string('remark', 255)->nullable()->comment('备注描述');
                $table->timestamps();
                $table->comment('设置分组表');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_site_config_items');
        Schema::dropIfExists('sys_site_config_group');
    }
};
