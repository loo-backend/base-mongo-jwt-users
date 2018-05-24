<?php

use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::connection($this->connection)
        ->table('users', function (Blueprint $table)
        {

            $table->uuid('user_uuid');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('administrator')->default(User::REGULAR_USER);
            $table->boolean('active')->default(false);
            $table->multiLineString('roles');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::connection($this->connection)
        ->table('users', function (Blueprint $table)
        {
            $table->dropIndex();
            $table->drop();
        });

    }
}
