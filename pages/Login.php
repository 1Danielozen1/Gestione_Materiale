<?php
// Avvia l'output buffering
ob_start();

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

// Setta l'header della pagina
$_POST['titolo'] = 'Login Page';
$_POST['path'] = '..';
include_once("../templates/Header.php");
?>
<h1 id="titlo">RESTITUITIS</h1>
<form id="form2" class="shadow needs-validation rounded position-absolute top-50 start-50 translate-middle" action="../checks/CheckLogin.php" method="POST">

    <h1 id="loginTitle" style="margin-bottom:10%;">Login</h1>

    <!-- Login Error -->
    <?php
    if (isset($_GET['error'])) {
        echo "<div class='p-3 alert alert-danger' role='alert'>
                    E-Mail o Password errati. 
                </div>";
    }
    ?>
    <!-- Fine Login Error -->

    <!-- E-Mail -->
    <div class="row mb-4">
        <label id="user" for="inputText3" class="text-black col-form-label fs-4">E-Mail</label>
        <div class="col-sm-20">
            <input type="text" class="p-3 form-control" placeholder="E-Mail" id="email" name="email" pattern='^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$' style="text-align: left" required>
        </div>
    </div>
    <!-- Fine E-Mail -->

    <!-- Password -->
    <div class="row mb-4">
        <label id="password" for="inputPassword3" class="text-black col-form-label fs-4">Password</label>
        <div class="col-sm-20">
            <input type="password" class="p-3 form-control" placeholder="Password" id="psw" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Caratteri inseriti insufficenti." required>
        </div>
    </div>
    <!-- Fine Password -->


    <!-- Sign in Button -->
    <div id="buttonContainer" class="mb-4">
        <button type="submit" class="btn btn-primary fs-4">Login</button>
    </div>
    <!-- Fine sign in Button -->

    <!-- Other options -->
    <div id="lrd">
        <t class="fs-5">Se non hai un account
            <a id="rd" class="link-blue link-offset-2 link-underline link-underline-opacity-0" href="./Registration.php">Registrati qui</a>
        </t><br>
    </div>
    <!-- Fine Other options -->
</form>

<script src="../bootstrap/bootstrap-5.3.3//dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>