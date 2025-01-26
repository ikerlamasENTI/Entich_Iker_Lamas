<?php
session_start();

if(!isset($_SESSION["id_creator"])){
	header("Location: login.php");
	exit();
}

require_once("template.php");

$query = "SELECT * FROM creators WHERE id_creator=".$_SESSION["id_creator"];

require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

$result = mysqli_query($conn, $query);

if(!$result){

	header("Location: login.php");
	exit();

}

if(mysqli_num_rows($result) != 1){
	header("Location: login.php");
	exit();
}




$creator = mysqli_fetch_array($result);





printHead("Dashboard de ".$creator["name"]);

openBody("Dashboard de  ".$creator["name"]);

require_once("dashboard_template.php");

openDashboard();
if(isset($_GET["add_game"])){

	//añadir juego
	echo <<<EOD
	<h2>Nuevo juego</h2>
	<form method="POST" action="dashboard_games_add.php">
		<p><label for="add_title">Título: </label><input type="text" id="add_title" name="titulo" /></p>
		<p><label for="add_image">Imagen: </label><input type="text" id="add_image" name="imagen" /></p>
		<p><label for="add_link">Enlace: </label><input type="text" id="add_link" name="link" /></p>
		<p><label for="add_price">Precio: </label><input type="text" id="add_price" name="price" /></p>
		<p><label for="add_trailer">Trailer: </label><input type="text" id="add_price" name="trailer" /></p>
		<p><input type="submit" value="Añadir Juego"></p>
	</form>
EOD;
}
else if (isset($_GET["id_game"])){

	//formulario modificar juego
	$id_game = $_GET["id_game"];
	echo <<<EOD
	<h2>Modificar juego</h2>
	<form method="POST" action="dashboard_games_modify.php">
		<p><label for="modify_title">Título: </label><input type="text" id="modify_title" name="titulo" /></p>
		<p><label for="modify_image">Imagen: </label><input type="text" id="modify_image" name="imagen" /></p>
		<p><label for="modify_link">Link: </label><input type="text" id="modify_link" name="link" /></p>
		<p><label for="modify_price">Price: </label><input type="text" id="modify_price" name="price" /></p>
		<p><label for="modify_trailer">Trailer: </label><input type="text" id="modify_trailer" name="trailer" /></p>
		<input type="hidden" name="id_game" value="{$id_game}" />
		<p><input type="submit" value="Actualizar Juego" />
	</form>
EOD;
}
else{
	
	//listado de juegos con el emnlace en el titulo tipo "dashboard_games.php?id_game=ID_JUEGO"
	echo <<<EOD
	<h2>Tus juegos</h2>
	<p><a href="dashboard_games.php?add_game=true">Añadir juego</a></p>
	<p><a href="dashboard_comments.php?add_game=true">Comentarios</a></p>
	EOD;
}

/*

lista con nuestros juegos

*/

closeDashboard();

closeBody();

?>
