<?php
session_start();

// Полная очистка корзины через кнопку

$_SESSION['basket'] = [];

header('Location:'.$_SERVER['HTTP_REFERER']);