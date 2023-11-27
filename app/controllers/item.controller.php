<?php

require_once './config.php';
require_once './app/models/item.model.php';
require_once './app/views/item.view.php';
require_once './app/models/category.model.php';

class itemController {

    private $model;
    private $view;
    private $categoryModel;


    function __construct() {
        $this->model = new itemModel();
        $this->categoryModel = new categoryModel();
        $isAdmin = AuthHelper::isAdmin();
        $userName = AuthHelper::getUsername();
        $this->view = new itemView($isAdmin, $userName);
    }


    public function showItem($id) {
        //muestra toda la info relacionada a un item.
        $item = $this->model->getItemInfo($id);
        $this->view->showItem($item);
    }


    public function showItems() {
        //
        $items = $this->model->getItems();

        usort($items, function($a, $b) {
            return $a->id_categoria - $b->id_categoria;
        });

        $this->view->showItems($items);
    }


    public function showNewItemForm() {
        //Muestra el form para ingresar un nuevo item
        AuthHelper::verify();
        $categories = $this->categoryModel->getAllCategories();
        $this->view->showNewItemForm(NULL, $categories);
    }


    public function procesarAgregar() {
        //Procesa los datos ingresador al form que se encarga de agregar un nuevo item
        AuthHelper::verify();
        $categories = $this->categoryModel->getAllCategories();
        $name = $_POST['name'];
        $cpu = $_POST['cpu'];
        $gpu = $_POST['gpu'];
        $motherboard = $_POST['motherboard'];
        $storage = $_POST['storage'];
        $ram = $_POST['ram'];
        $category = $_POST['category'];
        $image = $_POST['img'];

        if (empty($name) || empty($cpu) || empty($gpu) || empty($motherboard) || empty($storage) || empty($ram) || empty($category) || empty($image)) {
            $this->view->showNewItemForm("Revise que todos los campos tengan datos correctos y no esten vacios", $categories);
            return;
        }

        $this->model->newItem($name, $cpu, $gpu, $motherboard, $storage, $ram, $category, $image);

        header('Location: ' . BASE_URL);
    }


    public function showUpdateItemForm($id) {
        AuthHelper::verify();

        $pc = $this->model->getItemInfo($id);
        $categories = $this->categoryModel->getAllCategories();

        $name = $pc->nombre;
        $cpu = $pc->procesador;
        $gpu = $pc->grafica;
        $motherboard = $pc->mother;
        $storage = $pc->disco;
        $ram = $pc->ram;
        $selectedCategory = $pc->id_categoria;
        $image = $pc->imagen;


        $this->view->showUpdateItemForm(null, $id, $name, $cpu, $gpu, $motherboard, $storage, $ram, $selectedCategory, $image, $categories);
    }


    public function editItem($id) {
        //obtiene todos los datos ingresados en el form y con eso actualiza cada componente de la pc seleccionada.
        AuthHelper::verify();
        $name = $_POST['name'];
        $cpu = $_POST['cpu'];
        $gpu = $_POST['gpu'];
        $motherboard = $_POST['motherboard'];
        $storage = $_POST['storage'];
        $ram = $_POST['ram'];
        $selectedCategory = $_POST['category'];
        $image = $_POST['img'];
        $categories = $this->categoryModel->getAllCategories();

        if(empty($name) || empty($cpu) || empty($gpu) || empty($motherboard) || empty($storage) || empty($ram) || empty($selectedCategory) || empty($image)) {
            $this->view->showUpdateItemForm("Revise que todos los campos tengan datos correctos y no esten vacios", $id, $name, $cpu, $gpu, $motherboard, $storage, $ram, $selectedCategory, $image, $categories);
            return;
        }

        $this->model->updateItem($id, $name, $cpu, $gpu, $motherboard, $storage, $ram, $selectedCategory, $image);
        header('Location: ' . BASE_URL);
    }


    public function deleteItem($id) {
        //llama al modelo para que se encargue de eliminar el item seleccionado
        AuthHelper::verify();
        $this->model->deleteItem($id);
        header('Location: ' . BASE_URL);
    }


    public function showErrorPage() {
        $this->view->showErrorPage();
    }

}