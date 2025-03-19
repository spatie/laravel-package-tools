<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class create_table_discover_normal extends Migration
{
    public function up()
    {
        Schema::create('laravel-package-tools_table-discover-normal', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->timestamps();
        });
    }
}
