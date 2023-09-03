<?php

function debug($var): void {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    exit;
}

// Sanitizar el HTML
function s($html): string {
    $s = htmlspecialchars($html);
    return $s;
}

function authUser(): void {
    session_start();
    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function authAdmin(): void {
    session_start();
    if (!isset($_SESSION['admin']) && isset($_SESSION['login'])) {
        header('Location: /appointments');
    } else if (!isset($_SESSION['admin']) && !isset($_SESSION['login'])) {
        header('Location: /');
    }
}
