<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <?php
        // Scheda HOME
        echo '<a class="navbar-brand" href="' . $_POST['path'] . '/index.php" id = "navbar_str_2" style = "font-weight: bold;">HOME</a>';
        ?>

        <!-- Bottone navbar per telefono -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Fine Bottone navbar per telefono -->

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <!-- Navbar links -->
                <?php
                // Percorso per la pagina degli oggetti prenotati
                if ($_SESSION["ruolo"] == 1) {
                    echo '<li class="nav-item"><a class="nav-link" href="' . $_POST['path'] . '/pages/OggettiPrenotati.php" id = "navbar_str">Oggetti prenotati</a></li>';
                }
                if ($_SESSION["ruolo"] != 1) {
                    echo '<li class="nav-item"><a class="nav-link" href="' . $_POST['path'] . '/pages/TabellaDati.php" id = "navbar_str">Noleggi</a></li>';
                    echo '<li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" id="navbar_str" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Azioni
                    </a>
                    <ul class="dropdown-menu" style="background-color: lightgray;">
                        <li><a class="dropdown-item" href="' . $_POST['path'] . '/pages/Azioni.php?agg=1" id = "select_idx">Aggiungi Oggetto</a></li>
                        <li><a class="dropdown-item" href="' . $_POST['path'] . '/pages/Azioni.php?agg=2" id = "select_idx">Aggiungi Categoria</a></li>
                        <li><a class="dropdown-item" href="' . $_POST['path'] . '/pages/Azioni.php?agg=3" id = "select_idx">Modifica Oggetto</a></li>
                        <li><a class="dropdown-item" href="' . $_POST['path'] . '/pages/Azioni.php?agg=4" id = "select_idx">Modifica Categoria</a></li>
                        <li><a class="dropdown-item" href="' . $_POST['path'] . '/pages/Azioni.php?agg=5" id = "select_idx">Rimuovi Oggetto</a></li>
                        <li><a class="dropdown-item" href="' . $_POST['path'] . '/pages/Azioni.php?agg=6" id = "select_idx">Rimuovi Categoria</a></li>
                    </ul>
                </li>';
                }
                ?>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" id="navbar_str" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorie
                    </a>
                    <ul class="dropdown-menu" style="background-color: lightgray;">
                        <?php
                        // Carico le categorie nella select
                        $stmt = $conn->prepare("SELECT * FROM categorie");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        echo '<li><a class="dropdown-item" href="' . $_POST['percorso'] . '" id = "select_idx">Tutto</a></li>';
                        while ($row = $result->fetch_assoc()) {
                            echo '<li><a class="dropdown-item" href="' . $_POST['percorso'] . '?id_cat=' . $row['id'] . '" id = "select_idx">' . $row['categoria'] . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <!-- Fine Navbar links -->
            <?php
            // Creo il carrello, il pulsante log out e mostro il nome utente
            $img = '/img/cart.svg';
            if (count($_SESSION['oggetti']) > 0) {
                $img = '/img/cart-fill.svg';
            }
            echo '<div class = "col" id = "prd_right">';
            if ($_SESSION['ruolo'] == 1) {
                echo '<a class = "link-underline link-underline-opacity-0" href="' . $_POST['path'] . '/pages/Carrello.php" style = "margin-right: 2%">
                    <button type="button" class="btn btn-light">
                    <img src="' . $_POST['path'] . '' . $img . '" alt="Icona Carrello">
                    </button>
                    </a>';
            }
            echo '<t style="color: white; font-weight:bolder; margin-right:1%;" id = "saluto">Benvenuto, ' . $_SESSION["nome"] . ' ' . $_SESSION["cognome"] . '</t>
                    <a href="' . $_POST['path'] . '/pages/Login.php?destroy=1">
                    <button type="submit" class="btn btn-secondary fs-5 btn-outline-light">Log Out</button>
                    </a>
                    </div>';
            ?>
        </div>
    </div>
</nav>