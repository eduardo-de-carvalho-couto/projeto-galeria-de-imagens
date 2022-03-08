<?php

	namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

	class AppController extends Action {

		public function timeline(){

			$this->validaAutenticacao();

			$foto = Container::getModel("Foto");

			$this->view->imagens = $foto->getAll();
			
			$this->render('timeline');
		}

		public function seuPerfil(){

			$this->validaAutenticacao();

			$foto = Container::getModel("Foto");

			$foto->__set("id_usuario", $_SESSION['id']);

			$this->view->minhasImagens = $foto->minhasImagens();
				
			
			$this->render('seuperfil');
		}

		public function postarFoto(){

			$this->validaAutenticacao();

			if(isset($_FILES['arquivo'])){
				
				$arquivo = $_FILES['arquivo'];

				if($arquivo['error']){
					header("Location: /seu_perfil?erro=1");
				}

				if($arquivo['size'] > 2097152){
					header("Location: /seu_perfil?erro=2");
				}

				$nomeDoArquivo = $arquivo["name"];
				$novoNomeDoArquivo = uniqid();

				$extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

				if($extensao != "jpg" && $extensao != "png"){
					header("Location: /seu_perfil?erro=3");
				}
				//  >>../App/Fotos/<<
				$pasta = "imagens/";

				$path = $pasta . $novoNomeDoArquivo . "." . $extensao;
				$moverArquivo = move_uploaded_file($arquivo['tmp_name'], $path);

				if($moverArquivo){
					$foto = Container::getModel('Foto');
					$foto->__set("id_usuario", $_SESSION['id']);
					$foto->__set("legenda", $_POST['legenda']);
					$foto->__set("path", $path);

					$foto->salvar();

					header("Location: /seu_perfil?envio=sucesso");
				}
			}
		}

		public function pesquisar(){
			
			$this->validaAutenticacao();

			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';
			$tipoDePesquisa = isset($_GET['tipoDePesquisa']) ? $_GET['tipoDePesquisa'] : '';

			$pesquisa = array();

			if($pesquisarPor != '' && $tipoDePesquisa == "usuarios"){
				
				echo "Pesquisando algum usuario";


				$usuario = Container::getModel('Usuario');
				$usuario->__set("nome", $pesquisarPor);
				$usuario->__set("id", $_SESSION['id']);

				$pesquisa = $usuario->getAll();

			}else if($pesquisarPor != '' && $tipoDePesquisa == "imagens"){
				
				echo "Pesquisando alguma imagem";

				$foto = Container::getModel("Foto");
				$foto->__set("legenda", $pesquisarPor);
				$foto->__set("id_usuario", $_SESSION['id']);

				$pesquisa = $foto->pesquisarImagens();

			}else{
				header("Location: /timeline");
			}

			$this->view->pesquisa = $pesquisa;
			$this->view->tipoDePesquisa = $tipoDePesquisa;

			$this->render('pesquisar');
		}

		public function validaAutenticacao(){

			session_start();

			if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
				header("Location: /?login=erro");
			}
		}
	}
?>