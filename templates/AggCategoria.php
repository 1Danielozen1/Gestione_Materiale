<div id="form" class=" justify-content-center align-items-center" style = "margin-top: 5vh">

    <h2 style="color: black; text-align:center; margin-bottom:5vh; margin-top: 2%; font-weight: bolder;">AGGIUNGI CATEGORIA</h2>

    <form id="formdiv" enctype="multipart/form-data" class="row shadow needs-validation rounded" action="../checks/AggiungiCategoria.php" method="POST">

        <?php
        if (isset($_GET['success'])) {
            echo "<div class='p-3 alert alert-success' id = 'prd' role='alert'>
            Categoria aggiunta correttamente.
            </div>";
        }
        ?>

        <!-- Nome Categoria -->
        <div class="col-md-4 mb-4" id="prd" style="text-align: center;">
            <label id="user" class="text-black col-form-label fs-4">Nome Categoria</label>
            <input type="text" class="p-2 form-control" placeholder="Nome Categoria" id="validationCustom01" name="nome_categoria" pattern="[^'\x22]+" required>
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 1) {
                echo "<div class='p-1 alert alert-danger' role='alert' style ='margin-top: 1%'>
                            Categoria già esistente.
                      </div>";
            }
            ?>
        </div>
        <!-- Fine Nome Categoria -->

        <!-- Aggiungi Button -->
        <div id="buttonContainer">
            <button type="submit" class="btn btn-success fs-5">Aggiungi</button>
        </div>
        <!-- Fine Aggiungi Button -->
    </form>
</div>