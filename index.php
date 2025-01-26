<?php
session_start();

require_once("template.php");
printHead("ENTIch: Home");
openBody("Home");

require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

$query = "SELECT id_game, title, price FROM games";
$result = mysqli_query($conn, $query);

echo "<h1>Lista de Juegos</h1>";

echo "<table border= '1'>

		<thead>
			<tr>
				<th>Nombre del juego</th>
				<th>Precio</th>
				<th>Enlace</th>			
			</tr>
		</thead>
		<tbody>";

while($row = mysqli_fetch_assoc($result)){
	
	$id_game = $row['id_game'];
	$title = $row['title'];
	$price = $row['price'];

	 echo "<tr>";
	 echo "<td>{$title}</td>";
	 echo "<td>{$price}</td>";
	 echo "<td><a href='game.php?id_game={$id_game}'>Ver Juego</a></td>";
	 echo "</tr>";

}

echo "</tbody></table>";



closeBody();

?>
