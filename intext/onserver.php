<?php
/**
*
* Intext | lliure 5.x
*
* @Versão 5.0
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
	
}


?>