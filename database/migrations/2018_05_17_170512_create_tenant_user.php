<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantUser extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION'))
        ->table('tenant_user', function (Blueprint $table)
        {

            $table->uuid('tenant_uuid');
            $table->uuid('user_uuid');
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
         Schema::connection(env('DB_CONNECTION'))
        ->table('tenant_user', function (Blueprint $table)
        {
            $table->dropIndex();
            $table->drop();
        });
    }
}
