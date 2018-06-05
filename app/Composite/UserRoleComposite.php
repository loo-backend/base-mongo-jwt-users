<?php


namespace App\Composite;


use App\User;

/**
 * Class UserRoleComposite
 * @package App\Composite
 */
class UserRoleComposite extends AbstractUserRoleComposite
{

    /**
     * @var
     */
    protected $admin;

    /**
     * @var
     */
    protected $tenant;

    /**
     * @var
     */
    protected $regular;

    /**
     * @return $this
     */
    public function admin()
    {
        $this->admin = User::ADMIN_USER;
        return $this;
    }

    /**
     * @return $this
     */
    public function tenant()
    {
        $this->tenant = User::TENANT_USER;
        return $this;
    }

    /**
     * @return $this
     */
    public function regular()
    {
        $this->regular = User::REGULAR_USER;
        return $this;
    }
}
