<?php

$this->group(['middleware' => ['jwt.auth']], function () {

    $this->resource('/tenants', 'Tenant\TenantController')->except([
        'create', 'edit'
    ]);

});


$this->group(['middleware' => ['jwt.auth']], function () {

    $this->resource('/tenants.users', 'Tenant\TenantUserController')->except([
        'create', 'edit'
    ]);

});



