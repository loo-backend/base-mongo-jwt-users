<?php

$this->group(['middleware' => ['jwt.auth']], function () {

    $this->resource('privileges', 'Privilege\PrivilegeController')->only([
        'index', 'show'
    ]);

});
