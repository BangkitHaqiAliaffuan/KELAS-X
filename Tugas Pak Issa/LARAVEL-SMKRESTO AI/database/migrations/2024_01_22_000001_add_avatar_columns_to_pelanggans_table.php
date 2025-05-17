<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->string('avatar_type')->nullable()->after('image');
            $table->longText('avatar_data')->nullable()->after('avatar_type');
        });
    }

    public function down()
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->dropColumn(['avatar_type', 'avatar_data']);
        });
    }
};
