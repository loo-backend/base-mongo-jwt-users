<?php

$this->post('authenticate', 'Auth\AuthApiController@authenticate')->name('auth.login');
