<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenants extends Migration
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
        ->table('tenants', function (Blueprint $table)
        {

            $table->uuid('tenant_uuid');
            $table->string('company_name');
            $table->string('short_company_name');
            $table->multiLineString('databases');
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
        ->table('tenants', function (Blueprint $table)
        {
            $table->dropIndex();
            $table->drop();
        });

    }
}
