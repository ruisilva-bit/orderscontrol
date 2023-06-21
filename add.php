<?php
// Initialize the session
session_start();
require_once "config.php";
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["username"] == "tv"){
    header("location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $config = $_POST['config'];
    $descricao = $_POST['descricao'];
    $qnt = $_POST['qnt'];
    $encomenda = $_POST['Encomenda'];
    $data_saida = $_POST['data_saida'];
    $control = 0;

    if (empty($config)) {
        $errors = "Insira Configuração";
    }else if (empty($descricao)){
        $errors = "Insira Descrição";
    }else if (empty($qnt)){
        $errors = "Insira Quantidade";
    }else if ($qnt < 0){
        $errors = "Insira um valor positivo";
    }else if (empty($encomenda)){
        $errors = "Insira Encomenda";
    }else if (empty($data_saida)){
        $errors = "Insira Data de saída";
    }else{
        $sql = "INSERT INTO plano (config, descricao, qnt, qnt_control, Encomenda, data_saida, controlado) VALUES ('$config', '$descricao', '$qnt', '$control', '$encomenda', '$data_saida', '0')";
        mysqli_query($link, $sql);
        header('location: add.php');
    }
}	
?>

<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <title>AT Plano</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    * {
        box-sizing: border-box;
    }

    body {
        font: 14px sans-serif;
        text-align: center;
    }

    label {
        font-size: 1.3em;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        <form method="post" action="add.php" class="input_form">
            <div class="row">
                <div class="col">
                    <label for="config">Configuração</label>
                    <input type="text" name="config" class="form-control">
                </div>

                <div class="col">
                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" class="form-control">
                </div>

                <div class="col">
                    <label for="qnt">Quantidade</label>
                    <input type="number" name="qnt" class="form-control">
                </div>

                <div class="col">
                    <label for="Encomenda">Encomenda</label>
                    <input type="text" name="Encomenda" class="form-control">
                </div>

                <div class="col">
                    <label for="data_saida">Data de Saída</label>
                    <input type="date" name="data_saida" class="form-control">
                </div>
            </div>
            <button type="submit" name="submit" id="add_btn" class="btn btn-primary mt-2">Adicionar</button>
            <input type="reset" class="btn btn-secondary ml-2
   mt-2" value="Apagar">
            <a class="btn btn-link mt-2"
                href="<?php if ($_SESSION["username"] !== "Admin") {echo 'welcome';}else{echo 'welcomeadmin';}?>.php">Sair</a>
        </form>


        <center style="color: red;" class="mt-2"><?php if (isset($errors)) { ?><p><?php echo $errors; ?></p><?php } ?>
        </center>


        <table class="table table-striped mt32 customers-list mt-3">
            <thead>
                <tr>
                    <th>Configuração</th>
                    <th>Descrição</th>
                    <th>Qnt.</th>
                    <th>Encomenda</th>
                    <th>Data de Saida</th>
                </tr>
            </thead>

            <tbody>
                <?php 
		$carga = mysqli_query($link, "SELECT * FROM plano order by id desc LIMIT 10;");
        while ($row = mysqli_fetch_array($carga)) { ?>
                <tr>
                    <td><?php echo $row['config']; ?></td>
                    <td><?php echo $row['descricao']; ?></td>
                    <td><?php echo $row['qnt']; ?></td>
                    <td><?php echo $row['Encomenda']; ?></td>
                    <td><?php echo $row['data_saida']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


</body>

</html>