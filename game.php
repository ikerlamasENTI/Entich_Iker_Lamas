<?php
session_start();


require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);


$id_game = $_GET['id_game'];

$query = "SELECT title, header, price, `link`, trailer FROM games WHERE id_game = {$id_game}";

$result = mysqli_query($conn,$query);

$game = mysqli_fetch_assoc($result);

$title = $game['title'];
$price = $game['price'];
$link = $game['link'];
$image = $game['header'];

echo "<h2>{$title}</h2>";

echo "<figure><img src='img/{$image}'></figure>";

echo "<h3>Precio: {$price}</h3>";

echo "<h3>Link: {$link}</h3>";

$comment_query = "SELECT comments.comment, creators.username FROM comments JOIN creators ON comments.id_creator WHERE comments.id_game = {$id_game} AND creators.id_creator = comments.id_creator;";

$comment_result = mysqli_query($conn,$comment_query);

echo "<h3>COMENTARIOS</h3>";

echo "<ul>";
if (mysqli_num_rows($comment_result) > 0) {
		while($comment = mysqli_fetch_assoc($comment_result)){
				$username = $comment['username'];
				$comment_text = $comment['comment'];
				echo "<li><strong>{$username}</strong>{$comment_text}</li>";
		}
}else{
	 echo "<li>No hay comentarios para este juego.</li>";
}
echo "</ul>";

if(isset($_SESSION["id_creator"])){

     echo <<<EOD
	 <h4>Añadir comentario</h4>
	 <form method="POST" action="comment_insert.php">
	 	<input type="hidden" name="id_game" value="{$id_game}">
	 	<textarea name="comment" placeholder="Pon un comentario"></textarea>
		<p><input type="submit" value="Añadir comentario"></p>
     </form>
EOD;
}else{
	echo "Inicia session para añadir un comentario";
}

?>
