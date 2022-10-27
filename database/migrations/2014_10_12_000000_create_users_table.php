<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();

            $table->string('surname')->nullable();
            $table->string('email')->unique();
            $table->string('region')->nullable();
            $table->string('region_id')->nullable();
            $table->string('city')->nullable();
            $table->string('city_id')->nullable();
            $table->string('area')->nullable();
            $table->string('area_id')->nullable();
            $table->string('password');
            $table->string('role_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('active')->nullable();
            $table->string('active_pracent')->nullable();
            $table->string('status')->nullable();
            $table->string('balance')->default(0);
            $table->string('photo')->default('default.jpg');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('reset_password_code')->nullable();
            $table->string('tariff_plus')->nullable();
            $table->string('black_list')->default(1);
            $table->string('activity')->default(100);
            $table->string('priceJob')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
