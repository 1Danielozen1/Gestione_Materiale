<?php
// avvio la session e se l'attributo destroy è assegnato la distrugge e resta nella pagina
session_start();
if (isset($_GET["destroy"])) {
    session_unset();
    session_destroy();
    header("Location: ./login.php");
}

// se l'attributo login è assegnato reindirizza all'index
if (isset($_SESSION['login'])) {
    header("Location: ../index.php");
}

$_POST['titolo'] = 'Registration page';
$_POST['path'] = '..';
include_once("../templates/Header.php");
?>

<div id="form" class=" justify-content-center align-items-center">
    <form id="formdiv" class="row shadow needs-validation rounded" action="../checks/CheckRegistration.php" method="POST">

        <h1 id="loginTitle">Registrati</h1>

        <!-- Nome -->
        <div class="col-md-4" id="reg">
            <label id="user" class="text-black col-form-label fs-4">Nome</label>
            <input type="text" class="p-2 form-control" placeholder="Nome" id="validationCustom01" name="nome" pattern="[^'\x22]+" require>
        </div>
        <!-- Fine Nome -->

        <!-- Cognome -->
        <div class="col-md-4" id="reg">
            <label id="user" class="text-black col-form-label fs-4">Cognome</label>
            <input type="text" class="p-2 form-control" placeholder="Cognome" id="validationCustom02" name="cognome" pattern="[^'\x22]+" require>
        </div>
        <!-- Fine Cognome -->

        <!-- E-Mail -->
        <div class="col-md-4" id="reg">
            <label id="user" class="text-black col-form-label fs-4">E-Mail</label>
            <input type="text" class="p-2 form-control" placeholder="E-Mail" id="validationCustom03" name="email" pattern='^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$' require>
            <?php
            if (isset($_GET['e'])) {
                echo "<div class='p-1 alert alert-danger' role='alert' style = 'text-align: center;'>
                            E-Mail già registrata. 
                        </div>";
            }
            ?>
        </div>
        <!-- Fine E-Mail -->

        <!-- Indirizzo -->
        <div class="col-md-4" id="reg">
            <label id="user" class="text-black col-form-label fs-4">Indirizzo</label>
            <input type="text" class="p-2 form-control" placeholder="Indirizzo" id="validationCustom04" name="ind" require>
        </div>
        <!-- Fine Indirizzo -->

        <!-- Codice Fiscale -->
        <div class="col-md-4" id="reg">
            <label id="user" class="text-black col-form-label fs-4">Codice Fiscale</label>
            <input type="text" class="p-2 form-control" placeholder="Codice Fiscale" id="validationCustom05" name="codF" pattern="^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$" require>
            <?php
            if (isset($_GET['c'])) {
                echo "<div class='p-1 alert alert-danger' role='alert' style = 'text-align: center;'>
                            Codice Fiscale già registrato. 
                        </div>";
            }
            ?>
        </div>
        <!-- Fine Codice Fiscale-->

        <!-- Cellulare -->
        <div class="col-md-4" id="reg">
            <label id="user" class="text-black col-form-label fs-4">Cellulare</label>
            <input type="text" class="p-2 form-control" placeholder="Tel" id="validationCustom06" name="tel" pattern="[0-9]{10}" require>
            <?php
            if (isset($_GET['cr'])) {
                echo "<div class='p-1 alert alert-danger' role='alert' style = 'text-align: center;'>
                            Numero di telefono già registrato. 
                        </div>";
            }
            ?>
        </div>
        <!-- Fine Cellulare -->

        <!-- Comune -->
        <div class="col-md-4" id="reg">
            <label id="user" class="text-black col-form-label fs-4">Comune</label>
            <input type="text" class="p-2 form-control" placeholder="Comune" id="validationCustom07" name="comune" pattern="[^'\x22]+" require>
        </div>
        <!-- Fine Comune -->

        <!-- Data di nascita -->
        <div class="col-md-4" id="reg">
            <label id="user" class="text-black col-form-label fs-4">Data Nascita</label>
            <input type="date" class="p-2 form-control" placeholder="Data Nascita" id="validationCustom08" name="data" require>
        </div>
        <!-- Fine Data di Nascita -->

        <!-- Luogo di Nascita -->
        <div class="col-md-4 mb-1" id="reg">
            <label id="user" class="text-black col-form-label fs-4">Luogo di Nascita</label>
            <input type="text" class="p-2 form-control" placeholder="Luogo di Nascita" id="validationCustom09" name="ldn" pattern="[^'\x22]+" require>
        </div>
        <!-- Fine Luogo di nascita -->

        <!-- Ruolo -->
        <div class="col-md-4 mb-2" id="prd">
            <label id="ruolo" class="text-black col-form-label fs-4">Ruolo</label>
            <select class="form-select" aria-label="Default select example" name="tipo" id="tipo">
                <option value="1">Studente</option>
                <option value="2">Insegnante</option>
                <option value="3">ATA</option>
            </select>
            <?php
            if (isset($_GET['cis'])) {
                echo "<div class='p-1 alert alert-danger erroreCod' role='alert' style = 'text-align: center;'>
                            Codice errato.
                        </div>";
            }
            ?>
        </div>

        <script>
            /* se il campo selezionato è "Insegnate", aggiunge una input nel quale inserire il codice del docente*/
            document.getElementById("tipo").addEventListener("change", function(e) {
                e.preventDefault();
                clearError("codIS");
                clearError("codATA");
                clearError("erroreCod");
                if (document.getElementById("tipo").value == 2) {
                    document.getElementById("prd").insertAdjacentHTML('beforeend', '<input type="password" class="p-2 form-control codIS" placeholder="codice insegnate" id="psw" name="codIS"style="margin-top:2%"required>');
                } else if (document.getElementById("tipo").value == 3) {
                    document.getElementById("prd").insertAdjacentHTML('beforeend', '<input type="password" class="p-2 form-control codATA" placeholder="codice ATA" id="psw" name="codATA"style="margin-top:2%"required>');
                }

                function clearError(cls) {
                    let elem = document.getElementsByClassName(cls)
                    while (elem.length > 0) {
                        elem[0].parentNode.removeChild(elem[0])
                    }
                }
            });
        </script>
        <!-- Fine Ruolo -->

        <!-- Password -->
        <div class="row mb-3" id="prd">
            <label id="password" for="inputPassword3" class="text-black col-form-label fs-4">Password</label>
            <div class="col-sm-20">
                <input type="password" class="p-2 form-control" placeholder="Password" id="psw" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Caratteri inseriti insufficenti." required>
            </div>
        </div>
        <!-- Fine Password -->

        <!-- Conferma Password -->
        <div class="row mb-3" id="prd">
            <label id="password" for="inputPassword3" class="text-black col-form-label fs-4"> Conferma Password</label>
            <div class="col-sm-20">
                <input type="password" class="p-2 form-control" placeholder="Conferma Password" id="psw" name="confpsw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Caratteri inseriti insufficenti." required>
            </div>
            <?php
            if (isset($_GET['notequal'])) {
                echo "<div class='p-1 alert alert-danger' role='alert' style ='margin-top: 1%'>
                            Le password sono diverse.
                        </div>";
            }
            ?>
        </div>
        <!-- Fine Conferma Password -->

        <!-- Sign in Button -->
        <div id="buttonContainer" class="mb-4">
            <button type="submit" class="btn btn-primary fs-4">Invia</button>
        </div>
        <!-- Fine sign in Button -->

        <!-- Other options -->
        <div id="lrd">
            <t class="fs-5">Se hai un account fai il
                <a id="rd" class="link-blue link-offset-2 link-underline link-underline-opacity-0" href="./Login.php">Login qui</a>
            </t><br>
        </div>
        <!-- Fine Other options -->
    </form>
</div>

<script src="../bootstrap/bootstrap-5.3.3//dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>