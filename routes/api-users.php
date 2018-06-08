<?php

$this->name('users.')->group(function () {

    $this->post('/tenants', 'User\UserTenantController@store')->name('tenants.store');

    // $this->group(['middleware' => ['jwt.auth']], function () {

    //     $this->resource('/admins', 'User\UserAdminController')->except([
    //         'create', 'edit'
    //     ]);

    //     $this->resource('/tenants', 'User\UserTenantController')->except([
    //         'create', 'edit', 'store' , 'destroy'
    //     ]);

    // });

    $this->resource('/admins', 'User\UserAdminController')->except([
            'create', 'edit'
        ]);

        $this->resource('/tenants', 'User\UserTenantController')->except([
            'create', 'edit', 'store' , 'destroy'
        ]);

});
