<?php
/**
 * @package Framework Cakephp Adaptada para Winners Desenvolvimento de Sites e Sistemas
 * @version 1.0
 *
 * @author Winners
 * @link http://www.winnersdesenvolvimento.com.br
 *
 * @name Controller
 *
 */

App::uses('Controller', 'Controller');

class AppController extends Controller {
	public $modulos = array();

	/*
	* Metodo que funciona como construct para setar os modulos da instancia logada
	*/
	public function beforeFilter(){
		$this->verificar_acesso();
    	$this->set('modulos', $this->modulos);
   	}

   	/*
   	* Metodo que verificar o acesso do usuario e chama os metodos adicionais para setar os 
   	* modulos ativos e configurações
   	*/
	function verificar_acesso() {
		$dados = $this->Session->Read('Usuario');
		
		if (count($dados) < 1) {
			$this->Session->setFlash('Você não tem acesso a esta area do sistema!');
            return $this->redirect('/');
		}

		$this->verificar_modulos($dados['id']);

		return true;
	}

	/*
	*	Metodo que verifica as configurações e modulos do usuario logado
	*/
	function verificar_modulos($id_usuario) {
		$this->loadModel('ModuloRelacionaUsuario');

		$registros = $this->ModuloRelacionaUsuario->find('all',
		array('conditions' => 
			array('ModuloRelacionaUsuario.id_usuario' => $id_usuario, 
				  'ModuloRelacionaUsuario.ativo' => 1,
				  'Modulo.ativo' => 1
				)
			)
		);

		foreach ($registros as $indice => $modulo) {
			$this->modulos[$indice]['modulo'] = $modulo['Modulo']['modulo'];
			$this->modulos[$indice]['funcao'] = $modulo['Modulo']['funcao'];
			$this->modulos[$indice]['nome']   = $modulo['Modulo']['nome_modulo'];
			$this->modulos[$indice]['icone']  = $modulo['Modulo']['icone'];
		}
		
		return $this->modulos;
	}

	/*
	* Metodo que verifica se determinado modulo está ativo
	* @param array modulo
	*/
	function verificar_modulo_ativo($modulo) {
		$retorno = in_array($modulo, $this->modulos);
		return $retorno;
	}

}