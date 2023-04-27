<?php

	function getConexao(){
		
		try {
			
	/*$host= "mysql:host=localhost;dbname=dicionario;chatset=utf8";
	$user = "root";
	$senha = "";

	$pdo = new PDO($host, $user, $senha);*/

			$pdo = new PDO("sqlite:Database.db");
			
			return $pdo;

		} catch (Exception $e) {
			
			echo "Erro na conexao: ".$e->getMessage();
		}
	}


?>