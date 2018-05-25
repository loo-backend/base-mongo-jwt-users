<?php

$this->post('/tenants', 'User\UsersTenantController@store')->name('tenants.store');

$this->group(['middleware' => ['jwt.auth']], function () {

    $this->resource('admins', 'User\UsersAdminController')->except([
        'create', 'edit'
    ]);

    $this->resource('tenants', 'User\UsersTenantController')->except([
        'create', 'edit', 'store' , 'destroy'
    ]);

});
