<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaravelPackageToolsTableSubfolderExplicitNormal extends Migration
{
    public function up()
    {
        Schema::create('laravel-package-tools_table-subfolder-explicit-normal', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->timestamps();
        });
    }
}
