<?php

class AuthHelper {
    
    public static function init() {
        //se encarga de inicializar la sesion en caso de que no haya una activa.
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login($user) {
        //guarda las credenciales del usuario en un arreglo.
        AuthHelper::init();
        $_SESSION['username'] = $user->usuario;
        $_SESSION['id'] = $user->id;
        $_SESSION['rol'] = $user->rol;
        //var_dump($_SESSION['rol'] = $user->rol);
    }

    public static function isAdmin() {
        //nos devuelve un boolean falso (en caso que no haya un sesion activa) o verdadero (en caso que la haya)
        AuthHelper::init();
        //var_dump($_SESSION['rol']);
        return !empty($_SESSION['rol']) && $_SESSION['rol'] == 'admin';
    }

    public static function getUsername() {
        AuthHelper::init();
        if (isset($_SESSION['username'])) {
            return $_SESSION['username'];
        }
    }

    public static function verify() {
        //verifica si el usuario tiene los permisos necesarios para acceder a ciertas secciones de la pagina. En caso de no tenerlas llevará al usuario a la seccion de login
        AuthHelper::init();
        if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'admin') {
            header('Location: ' . BASE_URL . 'login');
            die();
        }
    }

    public static function logout() {
        AuthHelper::init();
        session_destroy();
    }

}