<?php
/**
*
* Intext
*
* @Versão 7.0
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
}


?>