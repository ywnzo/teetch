<?php

include('../config/db_connect.php');

function update() {
    $table = $_POST['table'];
    $vals = $_POST['vals'];
    $params = $_POST['params'];

    $result = DB::update($table, $vals, $params);
    if($result) {
        echo "Update succesfull!";
    } else {
        echo "Error while updating!";
    }
}

function delete() {
    $table = $_POST['table'];
    $params = $_POST['params'];

    $result = DB::delete($table, $params);
    if($result) {
        echo "Delete succesfull!";
    } else {
        echo "Error while deleting!";
    }
}

function select() {
    $cols = $_POST['cols'];
    $table = $_POST['table'];
    $params = $_POST['params'];

    $result = DB::select($cols, $table, $params);
    if($result) {
        echo json_encode($result);
    } else {
        echo "Error while deleting!";
    }
}

if(isset($_POST['method'])) {
    $method = $_POST['method'];
    if($method === 'update') {
        update();
    }
    if($method === 'delete') {
        delete();
    }
    if($method === 'select') {
        select();
    }
}

?>