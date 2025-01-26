<?php
session_start();
if(!isset($_SESSION["id_creator"])){
	header("Location: login.php");
	exit();
}

if(!isset($_POST["comment"])){
	die("ERROR 1: Formulario no enviado");
}

$raw_comment = $_POST["comment"];
$id_creator = $_SESSION["id_creator"];
$id_game = $_POST["id_game"];

require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

$query = "INSERT INTO comments (comment, id_creator, id_game) VALUES(
		    '{$raw_comment}','{$id_creator}','{$id_game}');";

$result = mysqli_query($conn,$query);

header("Location: game.php?id_game={$id_game}");
exit();


?>
