<?php

$this->name('adm.users.')->group(function () {

     $this->group(['middleware' => ['jwt.auth']], function () {

        $this->resource('/admins', 'Adm\User\UserAdminController')->except([
            'create', 'edit'
        ]);

        $this->resource('/tenants', 'Adm\User\UserTenantController')->only([
            'index', 'update' , 'show'
        ]);

        $this->resource('/regular', 'Adm\User\UserRegularController')->only([
            'index', 'update' , 'show'
        ]);

     });

});
