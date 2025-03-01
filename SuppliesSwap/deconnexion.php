<?php
session_start();

if (isset($_SESSION['membre']['nom'])) {
    
    session_unset();
    session_destroy();

    header('location: authentification.php');

    exit();
} else {
    echo "vous n'etes pas connecter";
}
