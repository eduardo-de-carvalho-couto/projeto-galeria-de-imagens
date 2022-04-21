<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['inscreverse'] = array(
			'route' => '/inscreverse',
			'controller' => 'indexController',
			'action' => 'inscreverse'
		);

		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);

		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$routes['timeline'] = array(
			'route' => '/timeline',
			'controller' => 'AppController',
			'action' => 'timeline'
		);

		$routes['seu_perfil'] = array(
			'route' => '/seu_perfil',
			'controller' => 'AppController',
			'action' => 'seuPerfil'
		);

		$routes['postar_imagem'] = array(
			'route' => '/postar_imagem',
			'controller' => 'AppController',
			'action' => 'postarImagem'
		);

		$routes['pesquisar'] = array(
			'route' => '/pesquisar',
			'controller' => 'AppController',
			'action' => 'pesquisar'
		);

		$routes['acao'] = array(
			'route' => '/acao',
			'controller' => 'AppController',
			'action' => 'acao'
		);

		$this->setRoutes($routes);
	}

}

?>