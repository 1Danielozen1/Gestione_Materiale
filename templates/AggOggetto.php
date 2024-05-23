<div id="form" class=" justify-content-center align-items-center">

    <h2 style="color: black; text-align:center; margin-bottom:5%; margin-top: 4vh; font-weight: bolder;">AGGIUNGI OGGETTO</h2>

    <form id="formdiv" enctype="multipart/form-data" class="row shadow needs-validation rounded" action="../checks/AggiungiOggetto.php" method="POST">
        <?php
        if (isset($_GET['success'])) {
            echo "<div class='p-3 alert alert-success' id = 'prd' role='alert'>
            Oggetto aggiunto correttamente.
            </div>";
        }
        ?>

        <!-- Nome Oggetto -->
        <div class="col-md-4" id="reg" style="text-align: center;">
            <label id="user" class="text-black col-form-label fs-4">Nome Oggetto</label>
            <input type="text" class="p-2 form-control" placeholder="Nome Oggetto" id="validationCustom01" name="nome_oggetto" pattern="[^'\x22]+" required>
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 3) {
                echo "<div class='p-1 alert alert-danger' role='alert' style ='margin-top: 1%'>
                            Oggetto già esistente.
                      </div>";
            }
            ?>
        </div>
        <!-- Fine Nome Oggetto -->

        <!-- Quantità -->
        <div class="col-md-4" id="reg" style="text-align: center;">
            <label id="user" class="text-black col-form-label fs-4">Quantità</label>
            <input type="number" class="p-2 form-control" value="1" min="1" name="quantita" required>
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 1) {
                echo "<div class='p-1 alert alert-danger' role='alert' style ='margin-top: 1%'>
                            Quantità non accettata.
                      </div>";
            }
            ?>
        </div>
        <!-- Fine Quantità -->

        <!-- Seleziona Categoria -->
        <div class="col-md-4 mb-4" style="text-align:center;">
            <label id="categoria" class="text-black col-form-label fs-4">Categoria</label>
            <select class="form-select" style="text-align:center;" name="nome_categoria">
                <?php
                // Carico le categorie
                $stmt = $conn->prepare("SELECT *
                                        FROM categorie ");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . $row['categoria'] . '</option>';
                }
                ?>
            </select>
        </div>
        <!-- Fine selezione categoria -->

        <!-- Descrizione -->
        <div class="input-group mb-3">
            <span class="input-group-text">Descrizione</span>
            <textarea class="form-control" aria-label="Descrizione" name="descrizione" placeholder="Scrivi qui...">Nessuna descrizione</textarea>
        </div>
        <!-- Fine Descrizione -->

        <!-- Immagine -->
        <div class="row mb-4" id='lrd'>
            <label id="categoria" class="text-black col-form-label fs-4">Immagine</label>
            <input type="file" class="p-3 form-control" name="immagine" required>
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 2) {
                echo "<div class='p-1 alert alert-danger' role='alert' style ='margin-top: 1%'>
                            Formato immagine non accettato.
                      </div>";
            } elseif (isset($_GET['error']) && $_GET['error'] == 4) {
                echo "<div class='p-1 alert alert-danger' role='alert' style ='margin-top: 1%'>
                    Nome immagine già esistente.
                    </div>";
            }
            ?>
        </div>
        <!-- Fine Immagine -->

        <!-- Aggiungi Button -->
        <div id="buttonContainer">
            <button type="submit" class="btn btn-success fs-5">Aggiungi</button>
        </div>
        <!-- Fine Aggiungi Button -->
    </form>
</div>