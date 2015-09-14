<?php
include("config.php");

/* colunas para a tabela do banco de dados. */
$arr_colunas = array("id","nome","data_de_nascimento","telefone","celular","cidade","uf","rg","cpf",
"cep","email","pai","mae","forma_de_contribuicao","outra_forma_contri","concordo","comentario","data_hora","situacao");

/* nome de todas as colunas da tabela, exceto a coluna "id". */
$arr_colunas_sem_id = array("nome","data_de_nascimento","telefone","celular","cidade","uf","rg","cpf",
"cep","email","pai","mae","forma_de_contribuicao","outra_forma_contri","concordo","comentario","data_hora","situacao");

$titulos_tabela = array(
	"nome" => "Nome",
	"data_de_nascimento" => "Data de Nascimento",
	"telefone" => "Telefone",
	"celular" => "Celular",
	"cidade" => "Cidade",
	"uf" => "UF",
	"rg" => "RG",
	"cpf" => "CPF",
	"cep" => "CEP",
	"email" => "Email",
	"pai" => "Pai",
	"mae" => "Mãe",
	"forma_de_contribuicao" => "Forma de Contribuição",
	"outra_forma_contri" => "Contribuição (Outro)",
	"concordo" => "Concordo",
	"comentario" => "Comentário",
	"data_hora" => "Data/Hora",
	"situacao" => "Situação de Pagamento"
);


function criar_banco_e_senha_adm($banco){
	global $arr_colunas;

	$tamanho_campos = 1000; //200
	$banco->criar_banco_de_dados();
	$banco->criar_tabela_sem_auto_inc("senha_adm", 200, array("id","senha"));
	if( $banco->obter_dado_do_campo_especifico("senha_adm","senha",0) == "" ){
		$banco->add("senha_adm","senha",encri_l(SENHA_ADM));
	}

	// tabela para os associados;
	$banco->criar_tabela("associados", $tamanho_campos, $arr_colunas);
}


function se_get(){
  if(isset($_GET["id"]) && (!empty($_GET["id"]))){
      return true;
  }else{ return false; }
}

function se_get_v($var){
  if(isset($_GET[$var]) && (!empty($_GET[$var]))){
      return true;
  }else{ return false; }
}

function ler_txt($arquivo_txt){
  $f = fopen($arquivo_txt, "r");
  if($f!=false){
    while(!feof($f)) {
      echo fgets($f) . "<BR>";
    }
    fclose($f);
  }
}

/* Usar esta função para redirecionar uma pagina sem utilizar a função 'header' do PHP;
 * a função header do PHP gera o aviso "headers already sent by" dentro do servidor, e não funciona; */
function redirecionar($pagina){
	echo "<script>window.location = \"{$pagina}\"</script>";
}


function obter_dados_formulario($array_dos_names_do_formulario)
{
	$campos = $array_dos_names_do_formulario;
	if( is_array($array_dos_names_do_formulario) )
	{
		$vars = array();
		foreach($campos as $a )
		{
			if( isset($_POST[$a]) )
			{
				if( empty($_POST[$a]) )
				{
					//echo "Campo {$a} vazio.<BR>";
				}else $vars[$a] = $_POST[$a];
			}
		}
		return $vars;
	}
}

/*  */
function se_registro(){
  $reg = "reg";
  return ( isset($_SESSION[$reg]) && ($_SESSION[$reg] == true) );
}

function destruir(){
	unset($_SESSION["reg"]);
	session_destroy();
  redirecionar("index.php");
}

function deslogar(){
	unset($_SESSION["log"]);
	session_destroy();
	redirecionar("index.php");
}

function sair_reg(){
	unset($_SESSION["reg"]);
	//session_destroy();
}

/* verifica se esta logado; */
function se_logado(){
	return ( isset($_SESSION["log"]) && ($_SESSION["log"] == true) );
}

function data_hora(){
	date_default_timezone_set('America/Sao_Paulo');
	$str = date("d/m/Y")."-".date("H:i:s");
	return $str;
}

/* encurta string maiores que 15, adicionando "...";
do contrario, retorna a mesma string. */
function encurtar_string($dado){
	$quan = 15;
	if(strlen($dado) > $quan){
		$dado = substr($dado, 0, $quan)."...";
		return $dado;
	}else{ return $dado; }
}

?>
