<?php 

require_once 'app/models/user.model.php';
require_once 'app/views/auth.view.php';
require_once 'app/helpers/auth.helper.php';

class authController {
    private $model;
    private $view;

    
    function __construct() {
        $this->model = new userModel();
        $isAdmin = AuthHelper::isAdmin();
        $this->view = new authView($isAdmin);
    }


    public function showLogin() {
        //muestra el login de la pagina
        $this->view->showLogin();
    }


    public function auth() {
        //guarda los datos ingresado (o no) en variables. En caso de no haber ingresados todos los datos, mostrara el error al usuario

        $password = $_POST['password'];
        $username = $_POST['username'];
        if (empty($password) || empty($username)) {
            $this->view->showLogin('Faltan completar campos');
            return;
        }

        //compara y verifica que los datos del usuario coincidan (autenticar)
        $user = $this->model->getByUsername($username);

        if ($user && password_verify($password, $user->contraseña)) {
            AuthHelper::login($user);
            header('Location: ' . BASE_URL);
        } else {
            $this->view->showLogin("Usuario inválido");
        }
    }


    public function logout() {
        AuthHelper::logout();
        header('Location: ' . BASE_URL);   
    }

}