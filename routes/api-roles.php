<?php

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
