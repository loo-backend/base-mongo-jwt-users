<?php

$this->name('adm.users.')->group(function () {

    $this->post('/tenants', 'User\UserTenantController@store')->name('tenants.store');

     $this->group(['middleware' => ['jwt.auth']], function () {

         $this->resource('/admins', 'User\UserAdminController')->except([
             'create', 'edit'
         ]);

         $this->resource('/tenants', 'User\UserTenantController')->only([
             'store', 'index', 'update' , 'show'
         ]);

     });

});
