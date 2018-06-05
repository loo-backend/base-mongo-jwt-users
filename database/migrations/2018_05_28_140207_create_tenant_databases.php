<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantDatabases extends Migration
{

    protected $connection = 'main';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::connection($this->connection)
        ->table('tenant_databases', function (Blueprint $table)
        {

            $table->uuid('name');
            $table->uuid('privilege_uuid');
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
        ->table('tenant_databases', function (Blueprint $table)
        {
            $table->dropIndex();
            $table->drop();
        });
    }

}
