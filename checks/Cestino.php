<?php
session_start();

if (isset($_GET['conf'])) {
    require("../config/db_config.php");

    // se conf è settato procede ad eliminare l'oggetto
    foreach ($_GET['vals'] as $val) {

        $stmt = $conn->prepare("DELETE FROM noleggio_materiali 
                                WHERE idOggetto = ?");
        $stmt->bind_param("i", $val);
        $stmt->execute();

        $stmt = $conn->prepare("SELECT immagine
                                FROM oggetti 
                                WHERE id = ?");
        $stmt->bind_param("i", $val);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        unlink('..' . $row['immagine']);

        $stmt = $conn->prepare("DELETE FROM oggetti 
                                WHERE id = ?");
        $stmt->bind_param("i", $val);
        $stmt->execute();
    }
    $count = 0;
    $cestino = array();

    $_SESSION["cestino"] = array();

    $stmt->close();
    $conn->close();
    header('location: ../pages/Azioni.php?agg=5');
} else {
    // rimuove l'oggetto dal cestino
    if (isset($_GET['rimuovi'])) {
        $count = 0;
        $cestino = array();

        # Elimina tutti gli oggetti con l'ID specificato
        foreach ($_SESSION["cestino"] as $cest) {
            if ($cest == $_GET["id"]) {
                unset($_SESSION["cestino"][$count]);
            } else {
                array_push($cestino, $cest);
            }
            $count++;
        }
        $_SESSION["cestino"] = array();
        $_SESSION["cestino"] = $cestino;
    } else {
        // inserisce l'oggetto nel cestino
        array_push($_SESSION['cestino'], $_GET['id']);
    }

    $s = '';
    foreach ($_SESSION['cestino'] as $ces) {
        $s = $s . "&vals[]=" . $ces;
    }

    header('location: ../pages/Azioni.php?agg=5' . $s . '');
}
?>