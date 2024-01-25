<?php

const HOST = 'localhost';
const USERNAME = 'root';
const PASSWORD = '';
const DATABASE = 'biblio_2024d31';
const PORT = 3306;

// création de la fonction permettant d'acceder à la base de données

function connection() {
    $c = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE, PORT);

    if(mysqli_connect_errno()) { // Retourne le code d'erreur du dernier appel de connexion
        emergency(mysqli_connect_error(), ['file' => __FILE__, "line" => __LINE__]);
        trigger_error(mysqli_connect_error(), E_USER_ERROR);
        
        
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    return $c;
}