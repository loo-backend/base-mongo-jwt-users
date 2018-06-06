<?php

namespace App\Composite;


/**
 * Class AbstractUserRoleComposite
 * @package App\Composite
 */
abstract class AbstractUserRoleComposite
{
    /**
     * @return mixed
     */
    abstract public function admin();

    /**
     * @return mixed
     */
    abstract public function tenant();

    /**
     * @return mixed
     */
    abstract public function regular();
}
