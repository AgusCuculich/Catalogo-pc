<?php 

require_once 'app/helpers/auth.helper.php';

class itemView {
    private $userName;
    private $isAdmin;

    function __construct($isAdmin, $userName) {
        $this->userName = $userName;
        $this->isAdmin = $isAdmin;
        /*var_dump($this->isAdmin);
        var_dump($this->userName);*/
    }
    
    public function showItem($item) {
        require 'templates/singleItem.phtml';
    }

    public function showItems($items) {
        //llama al template que muestra a modo de lista todos los items cargados en la db para que se muestren en el home.
        require 'templates/list.phtml';
    }

    /*En caso de haber un error en los datos ingresados al form se le podra pasar el mismo por parametro a la funcion para 
    que se lo muestre al usuario. En caso contrario el error será null(de manera default) y no se enseñara nada*/
    public function showNewItemForm($error = null, $categories) {
        require './templates/NewItemForm.phtml';
    }

    public function showUpdateItemForm($error, $id, $name, $cpu, $gpu, $motherboard, $storage, $ram, $selectedCategory, $image, $categories) {
        require './templates/updateItemForm.phtml';
    }

    public function showErrorPage() {
        require'./templates/errorPage.phtml';
    }
}
