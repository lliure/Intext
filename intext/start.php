<?php
/**
*
* Intext | lliure 5.x
*
* @Versão 6.0
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

$llHome = "?app=intext";
$llPasta = "app/intext/";
$llTable = PREFIXO.'intext';

$botoes = array(
	array('href' => $backReal, 'img' => $plgIcones.'br_prev.png', 'title' => $backNome)
	);

if(!isset($_GET['id']) && ll_tsecuryt()){	
	$botoes[] = array('href' => $llPasta.'step.php?ac=new&amp;tp=2'.(isset($_GET['gr']) ? '&amp;gr='.$_GET['gr'] : '' ), 'img' => $plgIcones.'folder.png', 'title' => 'Criar grupo', 'attr' => 'class="criar"');
	
	$botoes[] = array('href' => $llPasta.'step.php?ac=new&amp;tp=3'.(isset($_GET['gr']) ? '&amp;gr='.$_GET['gr'] : '' ), 'img' => $plgIcones.'text_letter_t.png', 'title' => 'Nova frase', 'attr' => 'class="criar"');
	
	$botoes[] = array('href' => $llPasta.'step.php?ac=new'.(isset($_GET['gr']) ? '&amp;gr='.$_GET['gr'] : '' ), 'img' => $plgIcones.'notepad_2.png', 'title' => 'Novo texto', 'attr' => 'class="criar"');
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
