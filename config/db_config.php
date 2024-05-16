<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestione_materiale";

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function criptpsw($psw)
{
    $salt = "_S9..MammaMia";
    $pswcript = crypt($psw, $salt);
    return $pswcript;
}