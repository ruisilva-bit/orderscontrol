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


?>


<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php

echo
'<table class="table table-dark mt-2">
	<thead>
		<tr>
			<th style="width: 15%;">Configuração</th>
			<th style="width: 50%;">Descrição</th>
			<th style="width: 10%;">Qnt.</th>
            <th style="width: 25%;">Encomenda</th>
		</tr>
	</thead>

	<tbody>';

    $carga = mysqli_query($link, "SELECT * FROM plano WHERE data_saida < date_add('$firstday', interval 1 week) AND qnt_control BETWEEN 0 AND qnt AND controlado = 0 order by data_saida asc;");
    		
    while ($row = mysqli_fetch_array($carga)) { 
            
        echo "<tr>";

        $data_saida = $row['data_saida']; 
        if ($data_saida < $today){
            echo '<td class="atrasado">' . $row['config'] . '</td>';
        }else if($data_saida == $today){
            echo '<td class="hoje">' . $row['config'] . '</td>';
        }else{
            echo '<td>' . $row['config'] . '</td>';
        };

        echo "<td>" . $row['descricao'] . "</td>";

        echo "<td>" . $row['qnt_control']. '/' . $row['qnt'] . "</td>";

        echo "<td>" . $row['Encomenda'] . "</td>";

        echo "</tr>";
    } 

        echo "</tbody>";

        echo "</table>";

mysqli_close($link);
 ?>	

</body>
</html>
