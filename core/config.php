<?php

function loadConfig() {
    $path = __DIR__ . '/../config.ini';

    if (!file_exists($path)) {
        throw new Exception("config.ini not found");
    }

    return parse_ini_file($path);
}
