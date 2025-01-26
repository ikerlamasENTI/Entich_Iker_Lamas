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
   !isset($_POST["trailer"]) ||
   !isset($_POST["id_game"])){
		die("ERROR 1: Formulario no bien hecho!");
   }

$raw_title = $_POST["titulo"];
if(strlen($raw_title) < 3){
	die("ERROR 2: Nombre del juego muy corto!");
}

$raw_image = $_POST["imagen"];

$raw_link = $_POST["link"];
$temp_link = filter_var($raw_link, FILTER_SANITIZE_URL);
if(!filter_var($temp_link,FILTER_VALIDATE_URL)){
	die("ERROR 3: URL no valida!");
}

$raw_price = $_POST["price"];
if($raw_price != null){
	if($raw_price > 70){
		die("ERROR EA: ta caro el jogo!");
	}
}
else{ $raw_price = 0; }

$raw_trailer = $_POST["trailer"];
if($raw_trailer != null){
	if(!filter_var($raw_trailer,FILTER_VALIDATE_URL)){
		die("ERROR 4: trailer no vlaido!");
	}
}

$temp_titulo = addslashes(trim($raw_title));
if($temp_titulo != $raw_title){
	die("ERROR 5: titulo no valido!");
}

$id = intval(addslashes(trim($_POST["id_game"])));

require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

$query = "UPDATE games SET title='{$temp_titulo}', `link`='{$temp_link}', header='{$raw_image}', price={$raw_price}, trailer='{$raw_trailer}' WHERE id_game={$id};";


$result = mysqli_query($conn,$query);

if(!$result){
	die("ERROR 6: no se pudo hacer la query.");	
}

header("Location: dashboard_games.php?id_game={$id}");
exit();

?>
