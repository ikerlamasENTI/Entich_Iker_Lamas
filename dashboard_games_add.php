<?php
session_start();
if(!isset($_SESSION["id_creator"])){
	header("Location: login.php");
	exit();
}

if(!isset($_POST["titulo"]) ||
   !isset($_POST["imagen"]) ||
   !isset($_POST["link"]) ||
   !isset($_POST["price"]) ||
   !isset($_POST["trailer"])){
	die("ERROR 1: Formulario no bien hecho!");
}

$raw_titulo = $_POST["titulo"];
if(strlen($raw_titulo)<3){
	die("ERROR 2: Título muy corto!");
}

$raw_image = $_POST["imagen"];

$raw_link = $_POST["link"];
$temp_link = filter_var($raw_link, FILTER_SANITIZE_URL);
if(!filter_var($temp_link,FILTER_VALIDATE_URL)){
	die("ERROR 3: URL no valida!");
}
$raw_price = $_POST["price"];
if($raw_price!=null){
	if($raw_price > 70){
		die("ERROR EA: ta caro el jogo!");
	}
}
else{$raw_price = 0;}
$raw_trailer = $_POST["trailer"];
if($raw_trailer != null){
	if(!filter_var($raw_trailer,FILTER_VALIDATE_URL)){
		die("ERROR 4: trailer no valido!");
	}
}
$temp_titulo = addslashes(trim($raw_titulo));
if($temp_titulo != $raw_titulo){
	die("ERROR 5: titulo no valido!");
}

require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);


$query = "INSERT INTO games (title,`link`, header, price, trailer) VALUES(
			'{$temp_titulo}','{$temp_link}','{$raw_image}',{$raw_price},'{$raw_trailer}');";

$result = mysqli_query($conn,$query);

$game = mysqli_insert_id($conn);

$id_creator = $_SESSION["id_creator"];

$query = "INSERT INTO creators_games (id_creator, id_game) VALUES(
            '{$id_creator}','{$game}');";

$result = mysqli_query($conn,$query);

header("Location: dashboard_games.php?id_game={$game}");
exit();

?>
