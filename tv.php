<?php
// Initialize the session
session_start();
require_once "config.php";
 
// Check if the user is logged in and username is tv, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["username"] !== "tv"){
    header("location: login.php");
    exit;


}

?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
	<meta http-equiv="refresh" content="">
    <title>TV</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body{ font: 1.9em sans-serif; text-align: center; overflow: hidden;}

    </style>

		<script type="text/javascript">
			function callTable() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open("GET","table.php", true);
    xmlhttp.send();
}


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
					callTable();
                },timeToRefresh);

 window.onload = callGraph;
 window.onload = callTable;

</script>

</head>
<body class="bg-dark">

   

<div class="container-fluid bg-dark text-white">
    <div class="logout">
	<img src="img/logo.jpg" style="width: 200px;" alt="logo">


		<div class="daysofweek" id="graph";>

		 </div>

		 <a href="logout.php"><i class="gg-log-out"></i></a>
	</div>
</div>

<div id="txtHint">

</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>