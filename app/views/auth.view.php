<?php

class authView {
    private $isAdmin;

    function __construct($isAdmin) {
        $this->isAdmin = $isAdmin;
    }

    public function showLogin($error = null) {
        require './templates/login.phtml';
    }
}