<?php

declare(strict_types= 1);
date_default_timezone_set("America/Recife");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
session_destroy(); // Destrói o "crachá" da sessão
header('Location: login.php'); // Manda de volta pro login
exit;