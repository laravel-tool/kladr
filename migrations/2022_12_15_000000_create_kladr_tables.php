<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::dropIfExists($this->getTable('version'));
        Schema::create($this->getTable('version'), function (Blueprint $table) {
            $table->unsignedInteger('version')->nullable(false)->primary();
            $table->string('url', 255)->nullable(false);
            $table->timestamps();
        });

        Schema::dropIfExists($this->getTable('altnames'));
        Schema::create($this->getTable('altnames'), function (Blueprint $table) {
            $table->id();
            $table->string('oldcode', 19);
            $table->string('newcode', 19);
            $table->char('level');
        });

        Schema::dropIfExists($this->getTable('doma'));
        Schema::create($this->getTable('doma'), function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->string('korp', 10);
            $table->string('socr', 10);
            $table->string('code', 19);
            $table->string('index', 6);
            $table->string('gninmb', 4);
            $table->string('uno', 4);
            $table->string('ocatd', 11);
        });

        Schema::dropIfExists($this->getTable('flat'));
        Schema::create($this->getTable('flat'), function (Blueprint $table) {
            $table->id();
            $table->string('code', 23);
            $table->string('np', 4);
            $table->string('gninmb', 4);
            $table->string('name', 40);
            $table->string('index', 6);
            $table->string('uno', 4);
        });

        Schema::dropIfExists($this->getTable('kladr'));
        Schema::create($this->getTable('kladr'), function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->string('socr', 10);
            $table->string('code', 13);
            $table->string('index', 6);
            $table->string('gninmb', 4);
            $table->string('uno', 4);
            $table->string('ocatd', 11);
            $table->string('status', 1);
        });

        Schema::dropIfExists($this->getTable('namemap'));
        Schema::create($this->getTable('namemap'), function (Blueprint $table) {
            $table->id();
            $table->string('code', 17);
            $table->string('name', 250);
            $table->string('shname', 40);
            $table->string('scname', 10);
        });

        Schema::dropIfExists($this->getTable('socrbase'));
        Schema::create($this->getTable('socrbase'), function (Blueprint $table) {
            $table->id();
            $table->string('level', 5);
            $table->string('scname', 10);
            $table->string('socrname', 29);
            $table->string('kod_t_st', 3);
        });

        Schema::dropIfExists($this->getTable('street'));
        Schema::create($this->getTable('street'), function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->string('socr', 10);
            $table->string('code', 17);
            $table->string('index', 6);
            $table->string('gninmb', 4);
            $table->string('uno', 4);
            $table->string('ocatd', 11);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->getTable('version'));
        Schema::dropIfExists($this->getTable('altnames'));
        Schema::dropIfExists($this->getTable('doma'));
        Schema::dropIfExists($this->getTable('flat'));
        Schema::dropIfExists($this->getTable('kladr'));
        Schema::dropIfExists($this->getTable('namemap'));
        Schema::dropIfExists($this->getTable('socrbase'));
        Schema::dropIfExists($this->getTable('street'));
    }

    protected function getTable($table): string
    {
        return config('kladr.database.table_prefix').$table;
    }
};
