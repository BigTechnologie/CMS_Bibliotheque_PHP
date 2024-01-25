<?php

ini_set("date.timeszone", "Europe/Paris");

const NOTICE = "NOTICE";
const ERROR = "ERROR";
const EMERGENCY = "EMERGENCY";

function writelog($level, $message, $params): string
{
    $path = __DIR__.'/../bibliotheque/var/log/connexion.txt';
    $date = date_format(date_create(), 'c');

    $message = sprintf("[%s] %s: %s %s\n", $date, $level, $message, json_encode($params));

    file_put_contents($path, $message, FILE_APPEND);

    //$message: contient l'information que vous souhaitez enregistrer dans le journal (log)
    return $message; 
}

function notice ($message, $params = []): void
{
    writelog(NOTICE, $message, $params);
}

function error($message, $params = []): void
{
    writelog(ERROR, $message, $params);
}

function emergency($message, $params = []): void
{
    $message = writelog(EMERGENCY, $message, $params);
    // envoie une notification (mail, sms, message) 
    mail("dev.technologie2018@gmail.com", "Erreur Critique", $message); 
}

