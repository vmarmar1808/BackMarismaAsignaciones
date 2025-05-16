<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('empresas', function (Blueprint $table) {
        $table->string('ubicacion')->nullable();
    });
}

public function down()
{
    Schema::table('empresas', function (Blueprint $table) {
        $table->dropColumn('ubicacion');
    });
}

};
