<?php

// namespace Nordic\Core;

class User extends Unit {

    //переопределение метода
    function setTable() {
        return 'core_users';
    }

    function login() {
        return $this->getField('login');
    }
}

?>