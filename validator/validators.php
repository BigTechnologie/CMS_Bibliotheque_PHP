<?php

/**
 * @param $value
 * @return bool retourne true si la valeur n'est pas vide, si non false
*/

function notBlank($value): bool
{
    return trim($value) != null; // test: "", false, 0, [], null  
}

/**
 * @param $value
 * @return bool retourne true si la valeur est valide, si non false
*/

function validName($name): bool
{
    if(preg_match('/^[a-zA-Z\-éèê]*$/', $name) === 1){
    }
    return false;
}

function validEmail($email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function fileNotBlank($file): bool
{
    if(!isset($file['error'])){
        trigger_error('La clé "error" n\'a pas été trouvé dans le tableau $file', E_USER_ERROR);
    }
    return $file['error'] !== UPLOAD_ERR_NO_FILE;
}

function validFileSize(array $file): bool
{
    if(!isset($file['error'])){
        trigger_error('La clé "error" n\'a pas été trouvé dans le tableau $file', E_USER_ERROR);
    }

    return $file['error'] !== UPLOAD_ERR_INI_SIZE && $file['error'] !== UPLOAD_ERR_FORM_SIZE;
}

// validation du type de fichier

function validFileType(array $file, array $mimes): bool
{
    if(!isset($file['type'])) {
        trigger_error('La clé "type" n\'a pas été trouvé dans le tableau $file', E_USER_ERROR);
    }

    return in_array($file['type'], $mimes); // $mime: est un standard permettant d'indiquer la nature et le format d'un document.
    
}
