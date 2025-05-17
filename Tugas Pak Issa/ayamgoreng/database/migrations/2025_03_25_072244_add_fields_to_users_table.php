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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['customer', 'staff', 'admin'])->default('customer')->after('password');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('role');
            $table->string('phone', 20)->nullable()->after('status');
            $table->text('address')->nullable()->after('phone');
            $table->timestamp('last_login')->nullable()->after('address');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'phone', 'address', 'last_login']);
        });
    }
};
