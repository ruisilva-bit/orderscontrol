<?php

require_once "config.php";

$today = date("Y-m-d");

function firstDayOfWeek($date)
{
    $day = DateTime::createFromFormat('Y-m-d', $date);
    $day->setISODate((int)$day->format('o'), (int)$day->format('W'), 1);
    return $day->format('Y-m-d');
}

$firstday = firstDayOfWeek($today);


//semana passada
$total_control_passada_query = "SELECT SUM(qnt_control) AS count FROM plano WHERE data_saida < '$firstday'";
$total_qnt_passada_query = "SELECT SUM(qnt) AS count FROM plano WHERE data_saida < '$firstday'";
$duration = $link->query($total_control_passada_query);
$duration1 = $link->query($total_qnt_passada_query);
$record = $duration->fetch_array();
$record1 = $duration1->fetch_array();
$total1 = $record['count'];
$total2 = $record1['count'];
 if ($total1 || $total2) {
	$total_passada = (($total1*100)/$total2);
}else{
	$total_passada = 0;
};

//segunda feira
$total_control_segunda_query = "SELECT SUM(qnt_control) AS count FROM plano WHERE data_saida = '$firstday'";
$total_qnt_segunda_query = "SELECT SUM(qnt) AS count FROM plano WHERE data_saida = '$firstday'";
$duration = $link->query($total_control_segunda_query);
$duration1 = $link->query($total_qnt_segunda_query);
$record = $duration->fetch_array();
$record1 = $duration1->fetch_array();
$total1 = $record['count'];
$total2 = $record1['count'];
 if ($total1 || $total2) {
	$total_segunda = (($total1*100)/$total2);
}else{
	$total_segunda = 0;
};

//terça feira
$total_control_terca_query = "SELECT SUM(qnt_control) AS count FROM plano WHERE data_saida = date_add('$firstday', interval 1 day)";
$total_qnt_terca_query = "SELECT SUM(qnt) AS count FROM plano WHERE data_saida = date_add('$firstday', interval 1 day)";
$duration = $link->query($total_control_terca_query);
$duration1 = $link->query($total_qnt_terca_query);
$record = $duration->fetch_array();
$record1 = $duration1->fetch_array();
$total1 = $record['count'];
$total2 = $record1['count'];
if ($total1 || $total2) {
	$total_terca = (($total1*100)/$total2);
}else{
	$total_terca = 0;
};

//quarta feira
$total_control_quarta_query = "SELECT SUM(qnt_control) AS count FROM plano WHERE data_saida = date_add('$firstday', interval 2 day)";
$total_qnt_quarta_query = "SELECT SUM(qnt) AS count FROM plano WHERE data_saida = date_add('$firstday', interval 2 day)";
$duration = $link->query($total_control_quarta_query);
$duration1 = $link->query($total_qnt_quarta_query);
$record = $duration->fetch_array();
$record1 = $duration1->fetch_array();
$total1 = $record['count'];
$total2 = $record1['count'];
if ($total1 || $total2) {
	$total_quarta = (($total1*100)/$total2);
}else{
	$total_quarta = 0;
};

//quinta feira
$total_control_quinta_query = "SELECT SUM(qnt_control) AS count FROM plano WHERE data_saida = date_add('$firstday', interval 3 day)";
$total_qnt_quinta_query = "SELECT SUM(qnt) AS count FROM plano WHERE data_saida = date_add('$firstday', interval 3 day)";
$duration = $link->query($total_control_quinta_query);
$duration1 = $link->query($total_qnt_quinta_query);
$record = $duration->fetch_array();
$record1 = $duration1->fetch_array();
$total1 = $record['count'];
$total2 = $record1['count'];
if ($total1 || $total2) {
	$total_quinta = (($total1*100)/$total2);
}else{
	$total_quinta = 0;
};

//sexta feira
$total_control_sexta_query = "SELECT SUM(qnt_control) AS count FROM plano WHERE data_saida = date_add('$firstday', interval 4 day)";
$total_qnt_sexta_query = "SELECT SUM(qnt) AS count FROM plano WHERE data_saida = date_add('$firstday', interval 4 day)";
$duration = $link->query($total_control_sexta_query);
$duration1 = $link->query($total_qnt_sexta_query);
$record = $duration->fetch_array();
$record1 = $duration1->fetch_array();
$total1 = $record['count'];
$total2 = $record1['count'];
if ($total1 || $total2) {
	$total_sexta = (($total1*100)/$total2);
}else{
	$total_sexta = 0;
};

?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
if ($total_passada == 100) {
    echo '<div class="days not">&larr;</div>';
} else {
    echo '<div class="days" style="color: red; font-weight: bold;">&larr;</div>';
}
    echo '<div class="days">S</div>';
    echo '<div class="days">T</div>';
    echo '<div class="days">Q</div>';
    echo '<div class="days">Q</div>';
    echo '<div class="days">S</div>';

if ($total_passada == 100) {
    echo '<div class="graph not" role="progressbar" aria-valuenow="'. floor($total_passada) .'" aria-valuemin="0" aria-valuemax="100" style="--value:'. floor($total_passada) .'"></div> ';
} else {
    echo '<div class="graph" role="progressbar" aria-valuenow="'. floor($total_passada) .'" aria-valuemin="0" aria-valuemax="100" style="--value:'. floor($total_passada) .'"></div> ';
}   

    echo '<div class="graph" role="progressbar" aria-valuenow="'. floor($total_segunda) .'" aria-valuemin="0" aria-valuemax="100" style="--value:'. floor($total_segunda) .'"></div>';

    echo '<div class="graph" role="progressbar" aria-valuenow="'. floor($total_terca) .'" aria-valuemin="0" aria-valuemax="100" style="--value:'. floor($total_terca) .'"></div>';

    echo '<div class="graph" role="progressbar" aria-valuenow="'. floor($total_quarta) .'" aria-valuemin="0" aria-valuemax="100" style="--value:'. floor($total_quarta) .'"></div>';

    echo '<div class="graph" role="progressbar" aria-valuenow="'. floor($total_quinta) .'" aria-valuemin="0" aria-valuemax="100" style="--value:'. floor($total_quinta) .'"></div>';

    echo '<div class="graph" role="progressbar" aria-valuenow="'. floor($total_sexta) .'" aria-valuemin="0" aria-valuemax="100" style="--value:'. floor($total_sexta) .'"></div>';
 
mysqli_close($link);
 ?>	

</body>
</html>