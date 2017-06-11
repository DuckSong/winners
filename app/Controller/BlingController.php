<?php

require_once(APP . 'Vendor/Bling/BlingSDK.php');

/**
* 
*/
class BlingController extends AppController
{
	
	protected $apiBling = new BlingSDK;

	public function configuracoes()
	{
		$this->layout = 'wadmin';

		$dados = $this->Bling->find('first', array(
				'conditions' => array(
					'ativo' => 1,
					'usuario_id' => $this->instancia
				)
			)
		);

		$this->set('dados', $dados);
	}

	public function salvar()
	{
		$request = $this->request['data']['dados'];

		$this->Bling->updateAll(
			array('ativo' => 0),
			array('usuario_id' => $this->instancia)
		);

		$dados = array(
			'api_key' => $request['api_key'],
			'usuario_id' => $this->instancia,
			'ativo' => 1
		);

		$this->Bling->save($dados);

		$this->Session->setFlash('Dados salvos com sucesso!');
     
        return $this->redirect('/bling/configuracoes');
	}

	public function enviar_venda_para_bling($id) 
	{
		$this->apiBling->apiKey = "5c0589b616596049ee9ea9ac42670cabc11e0342";

		$this->apiBling->postOrder($data, false);
	}

}