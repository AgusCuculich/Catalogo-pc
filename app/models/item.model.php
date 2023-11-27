<?php

require_once './app/models/model.php';

class itemModel extends Model {

    public function getItemInfo($id) {
        $query = $this->db->prepare('SELECT * FROM pc INNER JOIN categoria ON pc.id_categoria = categoria.id_categoria WHERE id = ?');
        $query->execute([$id]);
        $item = $query->fetch(PDO::FETCH_OBJ);
        return $item;
    }

    public function getItems() {
        $query = $this->db->prepare('SELECT * FROM pc INNER JOIN categoria ON pc.id_categoria = categoria.id_categoria');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteItem($id) {
        $query = $this->db->prepare('DELETE FROM pc WHERE id = ?');
        $query->execute([$id]);
    }

    public function updateItem($id, $name, $cpu, $gpu, $motherboard, $storage, $ram, $category, $image) {    
        $query = $this->db->prepare('UPDATE pc SET 
        id_categoria = ?,
        nombre = ?,
        procesador = ?,
        grafica = ?,
        mother = ?,
        disco = ?,
        ram = ?,
        imagen = ?
        WHERE id = ?');

        $query->execute([$category, $name, $cpu, $gpu, $motherboard, $storage, $ram, $image, $id]);
    }


    public function newItem($name, $cpu, $gpu, $motherboard, $storage, $ram, $category, $image) {
        $query = $this->db->prepare('INSERT INTO pc 
        (id, id_categoria, nombre, procesador, grafica, mother, disco, ram, imagen)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');

        $id = $this->db->lastInsertId();

        $query->execute([$id, $category, $name, $cpu, $gpu, $motherboard, $storage, $ram, $image]);
    }
}