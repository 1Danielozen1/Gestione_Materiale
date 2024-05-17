<div id="form" class=" justify-content-center align-items-center">

    <h2 style="color: black; text-align:center; margin-bottom:5%; margin-top: 2%; font-weight: bolder;">AGGIUNGI OGGETTO</h2>

    <form id="formdiv" class="row shadow needs-validation rounded" action="../checks/AggingiOggetto.php" method="POST">
        <!-- Nome Oggetto -->
        <div class="col-md-4" id="reg" style="text-align: center;">
            <label id="user" class="text-black col-form-label fs-4">Nome Oggetto</label>
            <input type="text" class="p-2 form-control" placeholder="Nome Oggetto" id="validationCustom01" name="nome_oggetto" pattern="[^'\x22]+" require>
        </div>
        <!-- Fine Nome Oggetto -->

        <!-- Quantità -->
        <div class="col-md-4" id="reg" style="text-align: center;">
            <label id="user" class="text-black col-form-label fs-4">Quantità</label>
            <input type="number" class="p-2 form-control" value="1" min="1" name="quantita" require>
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
        <div class="input-group mb-4">
            <span class="input-group-text">Descrizione</span>
            <textarea class="form-control" aria-label="Descrizione" placeholder="Scrivi qui..."></textarea>
        </div>
        <!-- Fine Descrizione -->

        <!-- Commento -->
        <div class="input-group mb-4">
            <span class="input-group-text">Commento</span>
            <textarea class="form-control" aria-label="Commento" placeholder="Scrivi qui..."></textarea>
        </div>
        <!-- Fine Commento -->

        <!-- Aggiungi Button -->
        <div id="buttonContainer">
            <button type="submit" class="btn btn-success fs-5">Aggiungi</button>
        </div>
        <!-- Fine Aggiungi Button -->
    </form>
</div>