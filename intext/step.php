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

switch(isset($_GET['ac']) ? $_GET['ac'] : 'home'){
	case 'home':
	
	$where = 'where a.grupo is null';
	if(isset($_GET['gr'])) {
		$dados_grupo = mysql_fetch_assoc(mysql_query('select * from '.$llTable.' where id = "'.$_GET['gr'].'" limit 1'));
		
		$where = 'where a.grupo = "'.$dados_grupo['id'].'"';
	
		$catHist = $dados_grupo['id'];
		
		while($catHist != 0){
			$sql = mysql_fetch_assoc(mysql_query('select id, nome_grupo, grupo from '.$llTable.' where id = "'.$catHist.'" limit 1'));
			$arraCat[] = array('nome' => $sql['nome_grupo'], 'id' => $sql['id']);
			$catHist = $sql['grupo'];
		}	
		
		$arraCat = array_reverse($arraCat);
	}
	?>
	<div class="boxCenter900">
		<div class="filtros">
			<div class="caminho">
				<?php
				if(isset($_GET['pesquisa'])){
					echo '<strong>Pesquisa por:</strong> <em>' . $_GET['pesquisa'] . '</em>';
					
					$where = 'where a.nome_grupo like "%'.$_GET['pesquisa'].'%" or  a.idd like "%'.$_GET['pesquisa'].'%" ';
				} else {
					echo '<span><a href="'.$llAppHome.'">Inicio</a></span>';
					
					if(isset($_GET['gr']))
						foreach($arraCat as $key => $valor)
							echo '<span><a href="'.$llAppHome.'&gr='.$valor['id'].'">'.$valor['nome'].'</a></span>';

				}
				?>
				
			
			</div>
			<?php
			if(ll_tsecuryt() &&  isset($_GET['gr'])){
				?>
				<div class="mover">
					<a href="#" class="bott"></a>					
					<div class="mover_opt">
						<span class="para">Mover para:</span>
						<form class="mvPara"> <input type="text"> </form>
						<div class="encontMove mostra"></div>
						<div class="irmaos mostra">
							<?php
							
							if(empty($dados_grupo['grupo']))
								$whereEncont = 'grupo is null';								
							else
								$whereEncont = 'grupo = "'.$dados_grupo['grupo'].'"';
								
							$query = 'select id, nome_grupo from '.PREFIXO.'intext where '.$whereEncont.' and id != "'.$dados_grupo['id'].'"  and tipo = "2" order by nome_grupo asc' ;
							
							$query = mysql_query($query);
							
							while($dados = mysql_fetch_assoc($query)){
								echo '<span class="itens" rel="'.$dados['id'].'"><span>'.str_pad($dados['id'], 6, 0, STR_PAD_LEFT) .'</span> '. $dados['nome_grupo'].'</span>';
							}
							?>
						</div>
						<hr>
						<div class="outros mostra">
							<span class="itens" rel="raiz">Raiz</span>
						</div>
					</div>
				</div>
				<?php
			}
			?>
			
			<div class="pesquisa">
				<form action="<?php echo $llAppOnServer , '&ac=pesquisa'; ?>" method="post">
					<input type="text" name="pesquisa" class="pesquisa_inp" rel="Encontrar registro" value="<?php echo (isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '');?>"/>
				</form>
			</div>
		</div>
		
		<?php		
		$navegador = new navigi();
		$navegador->tabela = $llTable;
		$navegador->query = 'select a.id, a.tipo, a.nome_grupo, if(a.idd is NULL, "NULL", a.idd) as idd from '.$navegador->tabela.' a '.$where.' order by if(a.tipo = 2, 1, 2) asc, a.tipo desc, a.idd ,a.nome_grupo asc' ;
		$navegador->exibicao = 'lista';
	
		if(ll_tsecuryt('admin')){
			$navegador->delete = true;
		}
		
		$navegador->configSel = 'tipo';
		$navegador->config[1] = array(	'link' => $llHome.'&amp;ac=edit&amp;id=',
										'ico' => $_ll['tema']['icones'].'notepad_2.png',
										'coluna' => 'idd',								
										);
											
		$navegador->config[3] = array(	'link' => $llHome.'&amp;ac=edit&amp;id=',
										'ico' => $_ll['tema']['icones'].'text_letter_t.png',
										'coluna' => 'idd',								
										);
											
											
		$navegador->config[2] = array(	'link' => $llHome.'&amp;gr=',
										'ico' => $_ll['tema']['icones'].'folder.png',
										'coluna' => 'nome_grupo',
										'rename' => true
										);
		$navegador->monta();
		?>
	</div>
	
	
	<script type="text/javascript">
		$('.pesquisa_inp').jf_inputext();
		
		<?php
		if(ll_tsecuryt() && isset($_GET['gr'])){
			?>
	
			$('.mvPara').submit(function(){
				var pes = $(this).find('input').val();
				$('.irmaos').hide();
				$('.encontMove').load('<?php echo $llAppSenHtml.'&ac=encontMove&atl='.$dados_grupo['id']; ?>', {pesquisa: pes});
				return false;
			});
			
			
			/*****/			
			function fecha_encontMove(){
				$('.mover_opt').hide();
				$('.bott').removeClass('aberto');
				
				$('.encontMove').html('');
				$('.mover_opt input').val('');
				$('.irmaos').show();
			}
			
			function abre_encontMove(){
				$('.mover_opt').show();
				$('.bott').addClass('aberto');
				
			}
			
			
			$('.bott').click(function(event){
				event.stopPropagation();
				
				if($('.mover_opt').css('display') == 'none')
					abre_encontMove();
				else
					fecha_encontMove();
					
				return false;
			});
			
			$('.mover_opt').click(function(event){
				event.stopPropagation();
			});
			
			$('html').click(function() {			
				fecha_encontMove();
			});
			
			
			/**/
			function move_destino(grupo, para){
				ll_load('<?php echo $llAppOnServer.'&ac=mover';?>&gr='+grupo+'&para='+para, function(){
					document.location.reload();
				});
			}
			
			$('.mostra span.itens').click(function(){
				move_destino(<?php echo $dados_grupo['id']; ?>, $(this).attr('rel'));
			});
			
			/*****/
			<?php
		}
		?>
	</script>
	<?php
	break;
	
	case 'edit':
		$linguagem = isset($_GET['ling']) ? $_GET['ling'] : $_ll['ling'];
	
		$consulta = 'select a.*, b.id as ling_id, b.texto
					from '.$llTable.' a
					
					inner join '.$llTable.'_texto b
					on b.id_fk = a.id and b.ling = "'.$linguagem.'"
					
					where a.id = "'.$_GET['id'].'"
					limit 1';
		
		$query = mysql_query($consulta);
		

		if(mysql_num_rows($query) == 0){
			echo '<div class="boxCenter">
					<div class="prd_no">
						<span class="frase">Não existe a versão em <strong>'.$ll_lista_idiomas[$linguagem].'</strong> desta categoria, você deseja criar agora?</span>
						<a href="'.$llPasta.'step.php'.jf_monta_link($_GET, array('ling', 'ac')).'&amp;ling='.$linguagem.'&amp;ac=newling" class="btnSim">Sim</a>
						<a href="'.$llHome.'&amp;ac=edit&amp;id='.$_GET['id'] .'" class="btnNao">Não</a>
					</div>
				</div>';
		} else {
			$dados = mysql_fetch_array($query);
			?>
			<div class="boxCenter">
				<?php
				if(ll_ling()){
					$ling = !isset($_GET['ling']) ? $_ll['ling'] : $_GET['ling'];
					?>
					<div class="abas">
						<?php				
						foreach((array) $_ll['conf']->idiomas as $chave => $valor)
							echo '<a href="'.jf_monta_link($_GET, 'ling').($chave != 'nativo' ? '&amp;ling='.$valor : '' ).'" class="item '.($valor == $ling ? 'ativo' : '').'">'.$ll_lista_idiomas[$valor].'</a>';
						?>
						
					</div>
					<?php
				}
				?>
				<?php /* <h2><?php echo $dados['nome']; ?></h2> */ ?>
				<form method="post" action="<?php echo $llPasta.'step.php?ac=write&amp;id='.$_GET['id'].(isset($_GET['ling']) ? '&amp;ling='.$_GET['ling'] : '').(!empty($dados['grupo']) ? '&amp;gr='.$dados['grupo'] : '');?>" class="form">
					<input type="hidden" name="ling_id" value="<?php echo $dados['ling_id'];?>" />
					<fieldset>
						<div>
							<table>
								<tr>
									<td style="width: 400px;">
										<label>Id dinâmico</label>
										<input type="text" name="idd" value="<?php echo $dados['idd'];?>" <?php echo ll_tsecuryt() ? '' : 'class="off" disabled'; ?>/>
										<span class="ex">Apenas letras e números e sem acentação, será convertido altomaticamente</span>
									</td>
									<td></td>
								</tr>
							</table>
						</div>
						<div>
							<?php
							if($dados['tipo'] == 1)
								echo '<label>Texto</label>'
									.'<textarea name="texto">'.$dados['texto'].'</textarea>';
							else
								echo '<label>Sua frase</label>'
									.'<input type="text" name="texto" value="'.$dados['texto'].'"/>';
							
							?>
							
						</div>
					</fieldset>
					
					<div class="botoes">
						<a href="<?php echo $backReal;?>">Voltar</a>
						<button type="submit" name="salvar">Gravar</button>
						<button type="submit" name="salvar-edit">Gravar e continuar editando</button>
					</div>
				</form>
			</div>
			
			<script type="text/javascript">	
				ajustaForm();

				tinyMCE.init({
					// General options
					mode : "textareas",
					theme : "lliure",
					width: '100%',
					height: '400px',
					
					plugins : "safari,pagebreak,table,advhr,advimage,advlink,contextmenu,paste,fullscreen,noneditable,nonbreaking,xhtmlxtras,template,icode",
					theme_advanced_buttons1 : "formatselect,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,forecolor,|,link,|,code,removeformat,fullscreen"					
				});
			</script>
			<?php
		}
	break;
	
	case 'write':
		require_once("../../etc/bdconf.php"); 
		require_once("../../includes/jf.funcoes.php"); 
		
		$retorno = jf_form_actions('salvar', 'salvar-edit');
		
		
		if(!empty($_POST['idd'])){
			$id = jf_result(PREFIXO.'intext_texto', array('id' => $_POST['ling_id']), 'id_fk');
			
			jf_update(PREFIXO.'intext', array('idd' => jf_formata_url($_POST['idd'])), array('id' => $id));
		}
		
		jf_update(PREFIXO.'intext_texto', array('texto' => $_POST['texto']), array('id' => $_POST['ling_id']));

		$_SESSION['aviso'] = array('Alteração realizada com sucesso!', 1);
		
		switch ($retorno){
			case 'salvar':
				$retorno = '../../index.php?app=intext'.(isset($_GET['gr']) ? '&gr='.$_GET['gr'] : '');
			break;
			
			case 'salvar-edit':
				$retorno = '../../index.php?app=intext&ac=edit&id='.$_GET['id'];
			break;		
		}
		
		header('location: '.$retorno);
	break;

	case 'new':
		header("Content-Type: text/html; charset=ISO-8859-1", true);
		require_once("../../etc/bdconf.php");
		require_once("../../includes/functions.php");

		$_ll['conf']= @simplexml_load_file('../../etc/llconf.ll');
		$_ll['ling'] = ll_ling();
		

		
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
		require_once("../../etc/bdconf.php"); 
		require_once("../../includes/jf.funcoes.php");
		
		jf_insert(PREFIXO.'intext_texto', array('id_fk' => $_GET['id'], 'ling' => $_GET['ling']));
		header('location: ../../index.php?app=intext&ac=edit&id='.$_GET['id'].'&ling='.$_GET['ling']);
	break;
}
?>
