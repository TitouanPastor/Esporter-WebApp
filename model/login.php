<?php

class Login
{

    private $dao;

    public function __construct()
    {
        require_once(realpath(dirname(__FILE__) . '/../DAO/loginDAO.php'));
        $this->dao = new LoginDAO();
    }

    public function checkLogin($username, $password, $role)
    {
        return $this->dao->checkLogin($username, $password, $role);
    }
}
