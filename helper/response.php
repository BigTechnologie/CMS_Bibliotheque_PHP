<?php

// Permet de faire une redirection HTTP vers une autre URL

function redirect($url)
{
    header('Location: '.$url, true, 302);
    exit;
}