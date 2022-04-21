<?php

	namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

	class AppController extends Action {

		public function timeline(){

			$this->validaAutenticacao();

			$imagem = Container::getModel("Imagem");

			$this->view->imagens = $imagem->getAll();
			
			$this->render('timeline');
		}

		public function seuPerfil(){

			$this->validaAutenticacao();

			$imagem = Container::getModel("Imagem");

			$imagem->__set("id_usuario", $_SESSION['id']);

			$this->view->minhasImagens = $imagem->minhasImagens();
				
			
			$this->render('seuperfil');
		}

		public function postarImagem(){

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
				//  >>../App/imagems/<<
				$pasta = "imagens/";

				$path = $pasta . $novoNomeDoArquivo . "." . $extensao;
				$moverArquivo = move_uploaded_file($arquivo['tmp_name'], $path);

				if($moverArquivo){
					$imagem = Container::getModel('Imagem');
					$imagem->__set("id_usuario", $_SESSION['id']);
					$imagem->__set("legenda", $_POST['legenda']);
					$imagem->__set("path", $path);

					$imagem->salvar();

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
				
				//echo "Pesquisando algum usuario";


				$usuario = Container::getModel('Usuario');
				$usuario->__set("nome", $pesquisarPor);
				$usuario->__set("id", $_SESSION['id']);

				$pesquisa = $usuario->getAll();

			}else if($pesquisarPor != '' && $tipoDePesquisa == "imagens"){
				
				//echo "Pesquisando alguma imagem";

				$imagem = Container::getModel("Imagem");
				$imagem->__set("legenda", $pesquisarPor);
				$imagem->__set("id_usuario", $_SESSION['id']);

				$pesquisa = $imagem->pesquisarImagens();

			}else{
				header("Location: /timeline");
			}

			$this->view->pesquisa = $pesquisa;
			$this->view->tipoDePesquisa = $tipoDePesquisa;
			$this->view->pesquisarPor = $pesquisarPor;

			$this->render('pesquisar');

			
		}

		public function acao(){

			$this->validaAutenticacao();

			$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
			$id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';
			$nome_do_usuario = isset($_GET['nome']) ? $_GET['nome'] : '';

			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']);

			if($acao == 'curtir') {
				$usuario->curtirUsuario($id_usuario_seguindo);
			} else if($acao = 'deixar_de_curtir') {
				$usuario->deixarCurtirUsuario($id_usuario_seguindo);
			}

			header("Location: /pesquisar?pesquisarPor=$nome_do_usuario&tipoDePesquisa=usuarios");

		}

		public function validaAutenticacao(){

			session_start();

			if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
				header("Location: /?login=erro");
			}
		}
	}
?>