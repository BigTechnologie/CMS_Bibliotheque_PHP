<?php

function form_errors($fieldName, $errors): string
{
    $html = "";
    if(isset($errors[$fieldName])) {
        $html = "<div class='text-danger'>";

        foreach($errors[$fieldName] as $error) {
            $html .= sprintf("<p>%s</p>", $error);
        }
        $html .= "</div>";

    }

    return $html;
}

// Pour sécuriser nos formulaires on utilise le csrf_token()

function csrf_token(): string
{

    // bin2hex(): converti des données binaires en representation hexadécimale
    $token = bin2hex(random_bytes(35)); // random_bytes:recupère des octets aléatoires cryptographiquement sécurisé
    $_SESSION[TOKEN] = $token; // création du token
    return $token; // reourne un token
}