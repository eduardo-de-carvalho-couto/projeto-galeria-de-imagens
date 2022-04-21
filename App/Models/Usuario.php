<?php

namespace App\Models;

	use MF\Model\Model;

	class Usuario extends Model {

		private $id;
		private $nome;
		private $email;
		private $senha;

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			return $this->$atributo = $valor;
		}

		//salvar
		public function registrarUsuario(){
			$query = "insert into usuarios(nome, email, senha) values(:nome, :email, :senha)";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':nome', $this->__get('nome'));
			$stmt->bindValue(':email', $this->__get('email'));
			$stmt->bindValue(':senha', $this->__get('senha'));
			$stmt->execute();

			return $this;
		}

		public function validarCadastro(){
			
			$valido = true;

			if(strlen($this->__get('nome')) < 3){
				$valido = false;
			}

			if(strlen($this->__get('email')) < 3){
				$valido = false;
			}

			if(strlen($this->__get('senha')) < 3){
				$valido = false;
			}

			return $valido;
		}

		public function verificarRegistroEmail(){
			$query = "select count(*) as contagem from usuarios where email = :email";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':email', $this->__get('email'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC)['contagem'];
		}

		//autenticar
		public function autenticar(){
			$query = "
				select
					id, nome, email
				from
					usuarios
				where
					email = :email and senha = :senha
			";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':email', $this->__get('email'));
			$stmt->bindValue(':senha', $this->__get('senha'));
			$stmt->execute();

			$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

			if($usuario['id'] != '' && $usuario['nome'] != ''){
				$this->__set('id', $usuario['id']);
				$this->__set('nome', $usuario['nome']);
			}

			return $this;
		}

		//recuperar
		public function getAll(){
			$query = "
					select
						u.id, 
						u.nome, 
						u.email,
						(
							select
								count(*)
							from
								curtidas as c
							where
								c.id_usuario = :id_usuario and c.id_usuario_curtindo = u.id
						) as curtindo_sn
					from
						usuarios as u
					where
						u.nome like :nome AND u.id != :id_usuario
			";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(":nome", "%".$this->__get("nome")."%");
			$stmt->bindValue(":id_usuario", $this->__get("id"));
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

		public function curtirUsuario($id_usuario_seguindo){
			$query = "insert into curtidas(id_usuario, id_usuario_curtindo) values(:id_usuario, :id_usuario_curtindo)";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->bindValue(':id_usuario_curtindo', $id_usuario_seguindo);
			$stmt->execute();

			return true;
		}

		public function deixarCurtirUsuario($id_usuario_seguindo){
			$query = "delete from curtidas where id_usuario = :id_usuario and id_usuario_curtindo = :id_usuario_curtindo";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->bindValue(':id_usuario_curtindo', $id_usuario_seguindo);
			$stmt->execute();

			return true;
		}
	}
?>