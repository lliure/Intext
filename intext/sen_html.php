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

switch(isset($_GET['ac']) ? $_GET['ac'] : 'home' ){
	
case 'encontMove':
	$_POST = jf_iconv2($_POST);	
	
	$erro = false;
	
	if(!empty($_POST['pesquisa'])){
		function categorias_arvore($cat){
			$slt = mysql_query('select * from '.PREFIXO.'intext where grupo = "'.$cat.'" and tipo = "2"') or die(mysql_error());
			
			$ret = array();
			while($dados = mysql_fetch_assoc($slt)){
				$ret[] = $dados['id'];
				$array_slt = categorias_arvore($dados['id']);
				if(!empty($array_slt))
					$ret = array_merge($array_slt, $ret);
			}
			
			return $ret;
		}
		
		$filhos = categorias_arvore($_GET['atl']);
		$filhos[] = $_GET['atl'];
		
		$filhos = implode(',', $filhos);
		
		$query = 'select id, nome_grupo from '.PREFIXO.'intext where nome_grupo like "%'.$_POST['pesquisa'].'%" and tipo = "2" and id not in('.$filhos.') order by nome_grupo asc' ;
		$query = mysql_query($query);
		
		if(mysql_num_rows($query) == 0)
			$erro = true;
		
		while($dados = mysql_fetch_assoc($query)){
			echo '<span class="itens" rel="'.$dados['id'].'"><span>'.str_pad($dados['id'], 6, 0, STR_PAD_LEFT) .'</span> '. $dados['nome_grupo'].'</span>';
		}
		
		if($erro == false){
			?>
			<script>
				$('.mostra.encontMove span.itens').click(function(){
					move_destino(<?php echo $_GET['atl']; ?>, $(this).attr('rel'));
				});	
			</script>
			<?php
		}
	} else {
		$erro = true;
	}
	
	if($erro)
		echo '<span class="itens">Nenhum registro encontrado</span>';
	
	break;	
}

?>