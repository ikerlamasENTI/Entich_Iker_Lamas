<?php
session_start();

if(!isset($_SESSION["id_creator"])){                      
    header("Location: login.php");       
    exit();                                         
}

$id_creator = $_SESSION["id_creator"];

require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

$query = "SELECT comments.comment, creators.username, games.title 
		  FROM comments 
		  JOIN games ON comments.id_game = games.id_game 
		  JOIN creators_games ON games.id_game = creators_games.id_game 
		  JOIN creators ON comments.id_creator = creators.id_creator
		  WHERE creators_games.id_creator = {$id_creator}";

$result = mysqli_query($conn,$query);

echo "<ul>";
if (mysqli_num_rows($result) > 0) {
		while($comments = mysqli_fetch_assoc($result)){
				$game = $comments['title'];
				$username = $comments['username'];
				$comment_text = $comments['comment'];
				echo "<li><strong>{$game}: {$username} </strong>- {$comment_text}</li>";
		}
}else{
	 echo "<li>No hay comentarios para este juego.</li>";
}
echo "</ul>";


?>
