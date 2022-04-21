<?php

namespace App;

class Connection {

	public static function getDb() {
		try {

			$conn = new \PDO(
				"mysql:host=db;dbname=galeria;charset=utf8",
				"root",
				"password" 
			);

			return $conn;

		} catch (\PDOException $e) {
			echo '<p> Erro:'.$e->getMessage().'</pre>';
		}
	}
}

?>