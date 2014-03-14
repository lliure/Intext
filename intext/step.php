<?php
/**
*
* Intext | lliure 6.x
*
* @Versão 5.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

switch(isset($_GET['ac']) ? $_GET['ac'] : 'home'){
	case 'home':

	$where = 'where a.grupo is null';
	if(isset($_GET['gr']))
		$where = 'where a.grupo = "'.$_GET['gr'].'"';
	
	?>
	<div class="boxCenter">
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
	<?php
	break;
	
	case 'edit':
		$linguagem = isset($_GET['ling']) ? $_GET['ling'] : $ll_ling;
	
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
						<a href="'.$_ll['app']['onserver'].'&amp;ling='.$linguagem.'&amp;ac=newling&id='.$_GET['id'].'" class="btnSim">Sim</a>
						<a href="'.$llHome.'&amp;ac=edit&amp;id='.$_GET['id'] .'" class="btnNao">Não</a>
					</div>
				</div>';
		} else {
			$dados = mysql_fetch_array($query);
			?>
			<div class="boxCenter">
				<?php
				if(ll_ling()){
					$ling = !isset($_GET['ling']) ? $ll_ling : $_GET['ling'];
					?>
					<div class="abas">
						<?php				
						foreach((array) $llconf->idiomas as $chave => $valor)
							echo '<a href="'.jf_monta_link($_GET, 'ling').($chave != 'nativo' ? '&amp;ling='.$valor : '' ).'" class="item '.($valor == $ling ? 'ativo' : '').'">'.$ll_lista_idiomas[$valor].'</a>';
						?>
						
					</div>
					<?php
				}
				?>
				<form method="post" action="<?php echo $_ll['app']['onserver'].'&ac=write&amp;id='.$_GET['id'].(isset($_GET['ling']) ? '&amp;ling='.$_GET['ling'] : '').(!empty($dados['grupo']) ? '&amp;gr='.$dados['grupo'] : '');?>" class="form">
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
						<button type="submit" name="salvar" class="confirm">Gravar</button>
						<a href="<?php echo $backReal;?>">Voltar</a>
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
				});
			</script>
			<?php
		}
	break;
	

}
?>
