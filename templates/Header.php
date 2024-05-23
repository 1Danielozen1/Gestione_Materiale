<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    // inserisce il titolo e la posizione del css assegnate nei vari file
    // Utilizza un $_POST che fa da variabile globale
    echo "<title>" . $_POST['titolo'] . "</title>";

    echo "<link href='" . $_POST['path'] . "/bootstrap/bootstrap-5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'
    integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>";

    echo "<link rel='stylesheet' href='" . $_POST['path'] . "/css/style.css' />";
    ?>
</head>

<body>
</body>
</html>