<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::connection(env('DB_CONNECTION_LOG'))
            ->table('log_users', function (Blueprint $table)
            {

                $table->string('action');
                $table->strin('user_id');
                $table->uuid('user_uuid');
                $table->string('description');
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

        Schema::connection(env('DB_CONNECTION_LOG'))
            ->table('log_users', function (Blueprint $table)
            {
                $table->dropIndex();
                $table->drop();
            });


    }
}
