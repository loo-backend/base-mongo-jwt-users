<?php

namespace App\Composite;


abstract class AbstractUserRoleComposite
{
    abstract public function admin();
    abstract public function tenant();
    abstract public function regular();
}
