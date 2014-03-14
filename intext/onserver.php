<?php
/**
*
* Intext | lliure 6.x
*
* @VersÃ£o 5.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @LicenÃ§a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
switch($_GET['ac']){
	case 'write':	
		$retorno = jf_form_actions('salvar', 'salvar-edit');
		
		if(!empty($_POST['idd'])){
			$id = jf_result(PREFIXO.'intext_texto', array('id' => $_POST['ling_id']), 'id_fk');
			
			jf_update(PREFIXO.'intext', array('idd' => jf_formata_url($_POST['idd'])), array('id' => $id));
		}
		
		jf_update(PREFIXO.'intext_texto', array('texto' => $_POST['texto']), array('id' => $_POST['ling_id']));

		$_SESSION['aviso'] = array('Alteração realizada com sucesso!', 1);
		
		switch ($retorno){
			case 'salvar':
				$retorno = $_ll['app']['home'].(isset($_GET['gr']) ? '&gr='.$_GET['gr'] : '');
			break;
			
			case 'salvar-edit':
				$retorno = $_ll['app']['home'].'&ac=edit&id='.$_GET['id'];
			break;		
		}
		
		header('location: '.$retorno);
	break;

	case 'new':
		$dados = array('tipo' => 1);

		if(isset($_GET['gr']))
			$dados['grupo'] = $_GET['gr'];
			

		if(isset($_GET['tp'])){
			$dados['tipo'] = $_GET['tp'];
			$dados['nome_grupo'] = 'Novo grupo';
		}
		
		jf_insert(PREFIXO.'intext', $dados);
		
		if(!isset($_GET['tp']) || $_GET['tp'] == 1 || $_GET['tp'] == 3)
			jf_insert(PREFIXO.'intext_texto', array('id_fk' => $jf_ultimo_id, 'ling' => $_ll['ling']));
		
		
		?>
		<script type="text/javascript">
			navigi_start();
		</script>
		<?php
	break;


	case 'newling':		
		$return = jf_insert(PREFIXO.'intext_texto', array('id_fk' => $_GET['id'], 'ling' => $_GET['ling']));
		header('location: '.$_ll['app']['home'].'&ac=edit&id='.$_GET['id'].'&ling='.$_GET['ling']);
	break;
}
?>
