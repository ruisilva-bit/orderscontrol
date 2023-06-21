<?php
// Initialize the session
session_start();
require_once "config.php";
 
// Check if the user is logged in and username is tv, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["username"] !== "qualidade"){
    header("location: login.php");
    exit;
}


if (isset($_GET['done'])) {
	$id = $_GET['done'];
	$sql =(mysqli_query($link,"SELECT * FROM plano WHERE id=".$id));
		$fetch = mysqli_fetch_array($sql);
		$qnt_control = $fetch['qnt_control'];
		$qnt = $fetch['qnt'];

	if (($qnt_control + 1) == $qnt) {

		mysqli_query($link, "UPDATE plano SET qnt_control= (qnt_control + 1) WHERE id=".$id);
		mysqli_query($link, "UPDATE plano SET controlado= (1) WHERE id=".$id);
		mysqli_query($link, "UPDATE plano SET data_controlo= (now()) WHERE id=".$id);
		header('location: qualidade.php');
	}else{
		mysqli_query($link, "UPDATE plano SET qnt_control= (qnt_control + 1) WHERE id=".$id);
		header('location: qualidade.php');
}
}



$today = date("Y-m-d");

function firstDayOfWeek($date)
{
    $day = DateTime::createFromFormat('Y-m-d', $date);
    $day->setISODate((int)$day->format('o'), (int)$day->format('W'), 1);
    return $day->format('Y-m-d');
}

$firstday = firstDayOfWeek($today);

$sql_qry = "SELECT SUM(qnt-qnt_control) AS count FROM plano WHERE data_saida < date_add('$firstday', interval 1 week) AND qnt_control BETWEEN 0 AND qnt";
$duration = $link->query($sql_qry);
$record = $duration->fetch_array();
$total = $record['count'];
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <title>Qualidade</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>

<script type="text/javascript">



 function callGraph() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("graph").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open("GET","daygraph.php", true);
    xmlhttp.send();
}

let timeToRefresh = 1000;
setInterval( function(){
                    callGraph();
                },timeToRefresh);

 window.onload = callGraph;

</script>

</head>
<body>

   

<div class="container-fluid">

<div class="logout">
	<img src="img/logo.jpg" style="width: 200px;" alt="logo">


		<div class="daysofweek" id="graph";>

		 </div>

		 <a href="logout.php"><i class="gg-log-out"></i></a>
	</div>
</div>



</div>

<table class="table table-striped mt32 customers-list">
	<thead>
		<tr>
			<th>Configuração</th>
			<th>Descrição</th>
			<th>Qnt.</th>
            <th>Encomenda</th>
			<th>Feito</th>
		</tr>
	</thead>

	<tbody>
    <?php 
		$carga = mysqli_query($link, "SELECT * FROM plano WHERE data_saida < date_add('$firstday', interval 1 week) AND qnt_control BETWEEN 0 AND qnt AND controlado = 0 order by data_saida asc;");
        while ($row = mysqli_fetch_array($carga)) { ?>
			<tr>
				<td class="<?php $data_saida = $row['data_saida']; if ($data_saida < $today){echo 'atrasado';}else if($data_saida == $today){echo 'hoje';} else{};?>"><?php echo $row['config']; ?></td>
				<td><?php echo $row['descricao']; ?></td>
				<td><?php echo $row['qnt_control'] . '/' . $row['qnt']; ?></td>
                <td><?php echo $row['Encomenda']; ?></td>
				<td><a href="qualidade.php?done=<?php echo $row['id']?>">Done</a></td>
			</tr>
        <?php } ?>	
	</tbody>
</table>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>