<?php


namespace MyProject\Controllers;

use MyProject\Models\Users\User;
use MyProject\Models\Users\UsersAuthService;
use MyProject\View\View;

class AbstractController
{
    /** @var View */
    protected $view;

    /** @var User|null */
    protected $user;

    /** @var User|null */
    protected $admin;

    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken();
        $this->admin = isset($this->user) && $this->user->isAdmin();

        $this->view = new View(__DIR__ . '/../../../templates');
        $this->view->setVar('user', $this->user);
        $this->view->setVar('admin', $this->admin);
    }

    public function getInputData()
    {
        return json_decode(
            file_get_contents('php://input'),
            true
        );
    }
}