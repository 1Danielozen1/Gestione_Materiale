<?php
// Avvia la session e se l'attributo login non è assegnato riporta alla pagina di login
session_start();
if (!isset($_SESSION['login'])) {
    header("location: ./pages/Login.php");
}
require("../config/db_config.php");

// Setta l'header della pagina
$_POST['titolo'] = 'Aggiungi';
$_POST['path'] = '..';
$_POST['percorso'] = "./Aggiungi.php";
include_once("../templates/Header.php");
include_once("../templates/Navbar.php");

if(isset($_GET["agg"])){
    if($_GET["agg"] == 1){
        include_once("../templates/Oggetto.php");
    }elseif($_GET["agg"] == 2){
        include_once("../templates/Categoria.php");
    }else{
        header("location: ../index.php");
    }
}
?>

<script src="../bootstrap/bootstrap-5.3.3//dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>