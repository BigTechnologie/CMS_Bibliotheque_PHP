<?php

session_start();

const FLASH = 'message_flash';
const USER = 'user';
const REDIRECT_URL = 'redirect_url';
const TOKEN = 'token';

function create_message_flash($type, $message)
{
    $_SESSION[FLASH][$type][] = $message;
}

function display_message_flash($type)
{
    if(!isset($_SESSION[FLASH])){
        return;
    }
    $flashes = $_SESSION[FLASH];

    if(!isset($flashes[$type])){
        return;
    }
    $messages = $flashes[$type];

    unset($_SESSION[FLASH][$type]);

    // La fonction construit un bloc HTML qui affiche les messages dans une boite d'alerte
    
    $html = "<div class ='alert alert-" . $type . "'>";
    foreach ($messages as $message) {
        $html .= "<p class= 'mb-0'>" .$message . "</p>";
    }
    $html .="</div>";

    return $html; 
    
}

// utilisée pour vérifier si un utilisateur est connecté en examinant les données stockées dans la session -----
function has_user_connect(): bool     
{
    return array_key_exists(USER, $_SESSION) && !empty($_SESSION[USER]); // la clé USER existe dans $_SESSION et elle n'est pas vide)=> true
}                                                                        // ce qui implique que l'utilisateur est considéré comme connecté.


// Permet de recuperer les données de l'utilisateur connecté à partir de la session

function get_user_connect(): ?array
{
    if(!has_user_connect()) {
        return null;
    }
    return $_SESSION[USER];
}