<?php

namespace App\Models;

	use MF\Model\Model;

	class Imagem extends Model {

		private $id;
		private $id_usuario;
		private $path;
		private $data_registro;

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			return $this->$atributo = $valor;
		}

		//salvar
		public function salvar(){
			$query = "insert into imagens(id_usuario, legenda, path) values(:id_usuario, :legenda, :path)";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(":id_usuario", $this->__get("id_usuario"));
			$stmt->bindValue(":legenda", $this->__get("legenda"));
			$stmt->bindValue(":path", $this->__get("path"));
			$stmt->execute();
		}


		//recuperar
		public function getAll(){
			$query = "
					select 
						id, id_usuario, legenda, path, DATE_FORMAT(data_registro, '%d%m%Y %H:%i') as data
					from
						imagens
					order by
						data desc
					";
			$stmt = $this->db->prepare($query);
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

		public function minhasImagens(){
			$query = "
					select 
						id, id_usuario, legenda, path, DATE_FORMAT(data_registro, '%d%m%Y %H:%i') as data
					from
						imagens
					where
						id_usuario = :id_usuario
					order by
						data desc
					";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(":id_usuario", $this->__get("id_usuario"));
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

		public function pesquisarImagens(){
			$query = "
					select 
						id, id_usuario, legenda, path, DATE_FORMAT(data_registro, '%d%m%Y %H:%i') as data
					from
						imagens
					where
						legenda like :legenda and id_usuario != :id_usuario
					order by
						data desc
					";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(":legenda", "%".$this->__get("legenda")."%");
			$stmt->bindValue(":id_usuario", $this->__get("id_usuario"));
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

	}
?>