<?php
$DSN = 'mysql:host=localhost:3308; dbname=cms';
$user = 'root';
$pass = '';



$connectingDB = new PDO($DSN, $user, $pass);
