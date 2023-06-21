<?php
// Initialize the session
session_start();
require_once "config.php";
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["username"] == "Admin" || $_SESSION["username"] == "tv" || $_SESSION["username"] == "qualidade"){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Olá, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Bem-vindo!</h1>
    <p>
    <a href="add.php" class="btn btn-primary ml-3 mt-3">Adicionar cargas ao plano</a>
    <a href="controlo.php" class="btn btn-primary ml-3 mt-3 mr-3">Controlo</a>
    <a href="reset-password.php" class="btn btn-warning mt-3">Nova password para <?php echo htmlspecialchars($_SESSION["username"]); ?></a>
    <a href="logout.php" class="btn btn-danger ml-3 mt-3">Sair</a> 
    </p>
</body>
</html>