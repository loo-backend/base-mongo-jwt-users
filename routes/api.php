<?php

$this->post('authenticate', 'Auth\AuthApiController@authenticate')
    ->name('auth.login');





$this->name('users.')->group(function () {

    $this->post('/tenants', 'User\UserTenantController@store')->name('tenants.store');

    $this->group(['middleware' => ['jwt.auth']], function () {

        $this->resource('admins', 'User\UserAdminController')->except([
            'create', 'edit'
        ]);

        $this->resource('tenants', 'User\UserTenantController')->except([
            'create', 'edit', 'store' , 'destroy'
        ]);

    });

});


$this->name('roles.')->group(function () {

    $this->group(['middleware' => ['jwt.auth']], function () {

        $this->resource('admins', 'Role\RoleAdminController')->only([
            'index', 'show'
        ]);

        $this->resource('tenants', 'Role\RoleTenantController')->only([
            'index', 'show'
        ]);

    });

});
