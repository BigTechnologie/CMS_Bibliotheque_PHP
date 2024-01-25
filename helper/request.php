<?php

function request($key, $default = null)
{

        if(!array_key_exists($key, $_POST)) {
            trigger_error(sprintf("La clé %s n'exite pas dans la table _POST", $key), E_USER_ERROR);
        }

        return !empty($_POST[$key]) ? $_POST[$key] : $default;
}

function query($key, $default = null)
{
    if(array_key_exists($key, $_GET) && !empty($_GET[$key])) {
        return $_GET[$key];
    }

    return $default;
}

