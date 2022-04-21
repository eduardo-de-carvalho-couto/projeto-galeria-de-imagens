<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$this->render('index');
	}

	public function inscreverse(){

		$this->view->usuario = array(
			'nome' => '',
			'email' => '',
			'senha' => ''
		);

		$this->view->erroRegistro = false;

		$this->render('inscreverse');
	}

	public function registrar(){

		$usuario = Container::getModel('Usuario');
		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', md5($_POST['senha']));

		//$usuario->registrarUsuario();
		
		if($usuario->validarCadastro() && $usuario->verificarRegistroEmail() == 0){
			
			$usuario->registrarUsuario();

			$this->render('cadastro');
		}else{

			$this->view->usuario = array(
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha']
			);

			$this->view->erroRegistro = true;

			
			$this->render('inscreverse');
		}
	}

}


?>