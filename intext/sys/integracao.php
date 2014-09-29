<?php
/**
*
* Intext | lliure 5.x
*
* @Versão 6.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

class intext {
	private static $_t = null;

	public static function set(){		
		if(func_num_args() > 1){
			$args = func_get_args();
			$where = 'a.grupo in('.implode(',', $args).')';
		} else {		
			$where = 'a.grupo = "'.func_get_arg(0).'"';		
		}
			
		
		$query = mysql_query('select a.idd, b.texto
							from '.PREFIXO.'intext a
							
							left join '.PREFIXO.'intext_texto b
							on b.id_fk = a.id and ling = "'.self::idioma_set().'"
							where '.$where);
							
		
		while($dados = mysql_fetch_assoc($query))
			self::$_t[$dados['idd']] = $dados['texto'];
	}

	public static function t($idd, $echo = true){	
		$print = $idd;
		
		if(isset(self::$_t[$idd]))
			$print = self::$_t[$idd];
		
		$replaces = func_get_args();
		
		unset($replaces[0]);
			
		if($echo != (true && false))
			$echo = true;
		else
			unset($replaces[1]);	
			

		if(count($replaces) > 0){		
			$print = preg_replace('/%[0-9]+/i', '\0$s', $print);				
			$print = @call_user_func_array('sprintf', array_merge((array) $print, $replaces));	
		}
		
		if($echo)
			echo $print;
			
		return $print;
	}

	public static function idioma_set($idioma = null){

		if(empty($idioma)){
			if(isset($_SESSION['ll']['idioma']))
				return $_SESSION['ll']['idioma'];
			else {
				$idiP = strtolower(str_replace('-', '_', $_SERVER["HTTP_ACCEPT_LANGUAGE"]));

				$idi = explode(';', $idiP);
				
				$idi = explode(',', $idi[0]);
				
				$idiP = $idi[0];
				
				$idioBd = array('pt' => 'pt_br', 'en' => 'en');
				
				if(array_key_exists($idiP ,$idioBd))
					return $idioBd[$idiP];
					
				$idiP = $idi[1];
					
				if(array_key_exists($idiP ,$idioBd))
					return $idioBd[$idiP];
			}
		} else {
			$_SESSION['ll']['idioma'] = $idioma;
		}
	}
}

?>