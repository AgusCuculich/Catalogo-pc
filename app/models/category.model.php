<?php

require_once './app/models/model.php';

class categoryModel extends Model {

    public function getAllCategories() {
        $query = $this->db->prepare('SELECT id_categoria, gama FROM categoria');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}