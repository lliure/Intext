<?php
/**
*
* Intext
*
* @Versão 9.0
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

switch(isset($_GET['ac']) ? $_GET['ac'] : 'home' ){
	
case 'pesquisa':
	$pesquisa = null;
	if(!empty($_POST['pesquisa']))
		$pesquisa = '&pesquisa='.urlencode($_POST['pesquisa']);
		
	header('location: '.$llAppHome.$pesquisa);
	break;
	
case 'mover':
	$grupo = $_GET['para'];

	if($_GET['para'] == 'raiz')
		$grupo = "NULL";

	jf_update(PREFIXO.'intext', array('grupo' => $grupo), array('id' => $_GET['gr']));

	ll_alert('Registro movido com sucesso!');
	break;
	
	
case 'new':

	$dados = array('tipo' => 1);

	if(isset($_GET['gr']))
		$dados['grupo'] = $_GET['gr'];
		
	$texto  = false;
		
	$_GET['tp'] = isset($_GET['tp']) ? $_GET['tp'] : 1;
	switch($_GET['tp']){
	case 1:
	case 3:
	case 4:
		$texto  = true;
		$dados['tipo'] = $_GET['tp'];
		break;
	case 2:
		$dados['tipo'] = $_GET['tp'];
		$dados['nome_grupo'] = 'Novo grupo';
		break;
	}		

	jf_insert(PREFIXO.'intext', $dados);
	
	if($texto)
		jf_insert(PREFIXO.'intext_texto', array('id_fk' => $jf_ultimo_id, 'ling' => $_ll['ling']));

	break;


case 'newling':

	ll_alert('Novo texto criado com sucesso!');
	jf_insert(PREFIXO.'intext_texto', array('id_fk' => $_GET['id'], 'ling' => $_GET['ling']));
	header('location: '.$_ll['app']['home'].'&ac=edit&id='.$_GET['id'].'&ling='.$_GET['ling']);
	break;

case 'write':
	$retorno = jf_form_actions('salvar', 'salvar-edit');

	if(!empty($_POST['idd'])){
		$id = jf_result(PREFIXO.'intext_texto', array('id' => $_POST['ling_id']), 'id_fk');

		jf_update(PREFIXO.'intext', array('idd' => jf_formata_url($_POST['idd'])), array('id' => $id));
	}

	$file = new fileup;
	$file->diretorio = '../uploads/intext/';
	$file->up();

	jf_update(PREFIXO.'intext_texto', array('texto' => $_POST['texto']), array('id' => $_POST['ling_id']));

	$_SESSION['aviso'] = array('Alteração realizada com sucesso!', 1);

	switch ($retorno){
		case 'salvar':
			$retorno = $_ll['app']['home'].(isset($_GET['gr']) ? '&gr='.$_GET['gr'] : '');
			break;

		case 'salvar-edit':
			$retorno = $_ll['app']['home']. '&ac=edit&id='.$_GET['id'];
			break;
	}

	header('location: '.$retorno);
	break;
}

?>