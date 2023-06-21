<?php
// Initialize the session
session_start();
require_once "config.php";
 
// Check if the user is logged in and username is tv, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["username"] == "tv" || $_SESSION["username"] == "qualidade"){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <title>Controlados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body{ font: 0.8em sans-serif; text-align: center; }
    </style>
</head>
<body>

   

<div class="container-fluid">
    <div class="logout"><h4>Controlo</h4> <div class="search"><input type="search" placeholder="Procurar..." class="form-control search-input mr-1" style="width: 250px;" data-table="customers-list"/> <button onclick="ExportToExcel()" class="btn btn-primary">Excel</button> </div><a href="login.php"><i class="fa fa-angle-double-left" style="font-size:30px;"></i></a></div>
</div>

<table class="table table-striped mt32 customers-list" id="tbl_exporttable_to_xls">
	<thead>
		<tr>
			<th>Configuração</th>
			<th>Descrição</th>
            <th>Qnt. Controlada</th>
			<th>Qnt.</th>
            <th>Encomenda</th>
            <th>Data de saida</th>
            <th>Data de Controlo</th>
		</tr>
	</thead>

	<tbody>
    <?php 
		$carga = mysqli_query($link, "SELECT * FROM plano WHERE controlado = 1 order by data_controlo desc;");
        while ($row = mysqli_fetch_array($carga)) { ?>
			<tr>
				<td><?php echo $row['config']; ?></td>
				<td><?php echo $row['descricao']; ?></td>
                <td><?php echo $row['qnt_control'] ?></td>
				<td><?php echo $row['qnt']; ?></td>
                <td><?php echo $row['Encomenda']; ?></td>
                <td><?php echo $row['data_saida']; ?></td>
                <td><?php echo $row['data_controlo']; ?></td>
			</tr>
        <?php } ?>	
	</tbody>
</table>


<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script>
        (function(document) {
            'use strict';

            var TableFilter = (function(myArray) {
                var search_input;

                function _onInputSearch(e) {
                    search_input = e.target;
                    var tables = document.getElementsByClassName(search_input.getAttribute('data-table'));
                    myArray.forEach.call(tables, function(table) {
                        myArray.forEach.call(table.tBodies, function(tbody) {
                            myArray.forEach.call(tbody.rows, function(row) {
                                var text_content = row.textContent.toLowerCase();
                                var search_val = search_input.value.toLowerCase();
                                row.style.display = text_content.indexOf(search_val) > -1 ? '' : 'none';
                            });
                        });
                    });
                }

                return {
                    init: function() {
                        var inputs = document.getElementsByClassName('search-input');
                        myArray.forEach.call(inputs, function(input) {
                            input.oninput = _onInputSearch;
                        });
                    }
                };
            })(Array.prototype);

            document.addEventListener('readystatechange', function() {
                if (document.readyState === 'complete') {
                    TableFilter.init();
                }
            });

        })(document);



        function ExportToExcel(type, date, fn, dl) {
       var elt = document.getElementById('tbl_exporttable_to_xls');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('controlo.' + (type || 'xlsx')));
    }
    </script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>