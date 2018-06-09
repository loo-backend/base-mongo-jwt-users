<?php

$this->post('authenticate', 'Auth\AuthApiController@authenticate')->name('auth.login');

$this->post('register', 'Auth\AuthApiController@register')->name('auth.register');
