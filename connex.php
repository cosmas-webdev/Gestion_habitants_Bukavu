<?php
try {

	$bd = new PDO('mysql:host=localhost;dbname=mydb','root','');

	} catch (Exception $e) {
		echo 'erreur connexion';
	}
?>
