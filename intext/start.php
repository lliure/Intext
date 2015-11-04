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

$llHome = "?app=intext";
$llPasta = "app/intext/";
$llTable = PREFIXO.'intext';

$botoes = array(
	array('href' => $backReal, 'fa' => 'fa-chevron-left', 'title' => $backNome)
	);

if(!isset($_GET['id']) && ll_tsecuryt()){	
	$botoes[] = array('href' => $_ll['app']['onserver'].'&ac=new&amp;tp=2'.(isset($_GET['gr']) ? '&amp;gr='.$_GET['gr'] : '' ), 'fa' => 'fa-folder', 'title' => 'Criar grupo', 'attr' => 'class="criar"');
	
	$botoes[] = array('href' => $_ll['app']['onserver'].'&ac=new&amp;tp=3'.(isset($_GET['gr']) ? '&amp;gr='.$_GET['gr'] : '' ), 'fa' => 'fa-paragraph', 'title' => 'Nova frase', 'attr' => 'class="criar"');
	
	$botoes[] = array('href' => $_ll['app']['onserver'].'&ac=new'.(isset($_GET['gr']) ? '&amp;gr='.$_GET['gr'] : '' ), 'fa' => 'fa-align-left', 'title' => 'Novo texto', 'attr' => 'class="criar"');
}

echo app_bar('Intext', $botoes);

require_once('step.php');
?>

<script type="text/javascript">
	$('.criar').click(function(){
		ll_load($(this).attr('href'), function(){
			navigi_start();
		});
		return false;
	});
</script>
