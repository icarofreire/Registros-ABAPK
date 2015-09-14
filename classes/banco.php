<?php
include_once("cripto/main.php");/* classe de criptografia; */


class banco
{

public static $servidor;
public static $usuario;
public static $senha;
public static $nome_do_banco;
public static $connect = null;

function __construct($ser,$usu,$sen,$nome)
{
     self::$servidor = $ser;
     self::$usuario = $usu;
     self::$senha = $sen;
     self::$nome_do_banco = $nome;
}

public static function conectar()
{
    self::$connect = @mysql_connect(self::$servidor,self::$usuario,self::$senha)or die(mysql_error());
    @mysql_select_db(self::$nome_do_banco, self::$connect)or die(mysql_error());
    //mysql_set_charset ( 'utf8' , $connect );
}

public static function fechar()
{
    @mysql_close(self::$connect);
}

public static function criar_banco_de_dados()
{
	$nome_do_banco_de_dados = self::$nome_do_banco;
	$link = @mysql_connect(self::$servidor,self::$usuario,self::$senha)or die(mysql_error());
	$sql = "CREATE DATABASE {$nome_do_banco_de_dados}";
    @mysql_query($sql, $link);
}

public static function se_tabela_existe($nome_da_tabela)
{
	self::conectar();
	$flag = null;
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$nome_da_tabela."'"))==1) $flag = true;
	else $flag = false;
	self::fechar();
	return $flag;
}

public static function criar_tabela($nome_da_tabela, $tamanho_dos_campos, $array_de_campos_da_tabela)
{
$nome_do_banco_de_dados = self::$nome_do_banco;
if( is_array($array_de_campos_da_tabela) )
{
if( self::se_tabela_existe($nome_da_tabela) == false )
{
	for($a = 0; $a < (count($array_de_campos_da_tabela)); $a++)
	{
		$array_de_campos_da_tabela[$a] = str_replace(" ","_",$array_de_campos_da_tabela[$a]);
	}
	$link = @mysql_connect(self::$servidor,self::$usuario,self::$senha)or die(mysql_error());
	@mysql_select_db($nome_do_banco_de_dados, $link)or die(mysql_error());

	$campos = $array_de_campos_da_tabela;
	$campos[0] = "CREATE TABLE {$nome_da_tabela} (".$campos[0]." INT NOT NULL AUTO_INCREMENT PRIMARY KEY,";
	for($a = 1; $a < (count($campos)-1); $a++) $campos[$a] = $campos[$a]." VARCHAR({$tamanho_dos_campos}) NOT NULL,";

	$campos[count($campos)-1] = $campos[count($campos)-1]. " VARCHAR({$tamanho_dos_campos}) NOT NULL)";
	$sql_tabela = implode("", $campos);
	@mysql_query($sql_tabela, $link)or die(mysql_error());
}
}
}

public static function criar_tabela_sem_auto_inc($nome_da_tabela, $tamanho_dos_campos, $array_de_campos_da_tabela)
{
$nome_do_banco_de_dados = self::$nome_do_banco;
if( is_array($array_de_campos_da_tabela) )
{
if( self::se_tabela_existe($nome_da_tabela) == false )
{
	for($a = 0; $a < (count($array_de_campos_da_tabela)); $a++)
	{
		$array_de_campos_da_tabela[$a] = str_replace(" ","_",$array_de_campos_da_tabela[$a]);
	}
	$link = @mysql_connect(self::$servidor,self::$usuario,self::$senha)or die(mysql_error());
	@mysql_select_db($nome_do_banco_de_dados, $link)or die(mysql_error());

	$campos = $array_de_campos_da_tabela;
	$campos[0] = "CREATE TABLE {$nome_da_tabela} (".$campos[0]." INT NOT NULL PRIMARY KEY,";
	for($a = 1; $a < (count($campos)-1); $a++) $campos[$a] = $campos[$a]." VARCHAR({$tamanho_dos_campos}) NOT NULL,";

	$campos[count($campos)-1] = $campos[count($campos)-1]. " VARCHAR({$tamanho_dos_campos}) NOT NULL)";
	$sql_tabela = implode("", $campos);
	@mysql_query($sql_tabela, $link);//or die(mysql_error());
}
}
}

public static function add($tabela,$campo,$valor)
{
self::conectar();
	$flag = false;
       //$valor = escape($valor);
    if((is_array($campo)) and (is_array($valor)))
    {
        if(count($campo) == count($valor))
        {
            $inserir = "INSERT INTO {$tabela} (".implode(', ', $campo).") VALUES ('" . implode('\', \'', $valor) . "')";
            @mysql_query($inserir)or die(mysql_error());
            $flag = true;
        }
    }else{
        $inserir = "INSERT INTO {$tabela} ({$campo}) VALUES ('{$valor}')";
        @mysql_query($inserir)or die(mysql_error());
        $flag = true;
    }
    return $flag;
self::fechar();
}

public static function mod($tabela,$campo,$numero_do_id,$valor)
{
	self::conectar();
	$flag = @mysql_query("update {$tabela} set {$campo}='{$valor}' where id = {$numero_do_id}");
	self::fechar();
	return $flag;
}

public static function mod_c($tabela,$campo,$id,$numero_do_id,$valor)
{
	self::conectar();
	$flag = @mysql_query("update {$tabela} set {$campo}='{$valor}' where {$id} = '{$numero_do_id}'");
	self::fechar();
	return $flag;
}

public static function mod_tabela($tabela,$novo_nome_tabela)
{
	self::conectar();
	$flag = @mysql_query("ALTER TABLE {$tabela} RENAME {$novo_nome_tabela}");
	self::fechar();
	return $flag;
}

public static function numero_registros($tabela)
{
	self::conectar();
	$re = @mysql_query("SELECT * FROM {$tabela}");
  $numero = mysql_num_rows($re);
	self::fechar();
	return $numero;
}

public static function excluir($tabela, $campo, $valor_do_campo_p_excluir)
{
  self::conectar();
  $sql = "DELETE FROM {$tabela} WHERE {$campo} = '{$valor_do_campo_p_excluir}'";
  $flag = @mysql_query($sql, self::$connect);
  self::fechar();
  return $flag;
}

public static function excluir_por_id($tabela, $valor_do_id)
{
  self::conectar();
  $sql = "DELETE FROM {$tabela} WHERE id = '{$valor_do_id}'";
  $flag = @mysql_query($sql, self::$connect);
  self::fechar();
  return $flag;
}

public static function excluir_tabela($tabela)
{
  self::conectar();
  $sql = "Drop Table {$tabela}";
  $flag = @mysql_query($sql, self::$connect);
  self::fechar();
  return $flag;
}

public static function obter_dado_do_campo_especifico($tabela,$campo,$numero_do_id)
{
	self::conectar();
	$sql = "SELECT * FROM {$tabela} WHERE id = '{$numero_do_id}'";
    $res = @mysql_query($sql, self::$connect);
    $row = mysql_fetch_assoc($res);
	$dado = $row[$campo];
	self::fechar();
	return $dado;
}

public static function obter_dado_do_campo_especifico_valor($tabela,$campo,$valor)
{
	$dado="";
	self::conectar();
	$sql = "SELECT * FROM {$tabela} WHERE {$campo} = '{$valor}'";
    $res = @mysql_query($sql, self::$connect);
    $row = mysql_fetch_assoc($res);
	$dado = $row[$campo];
	self::fechar();
	return $dado;
}

/* fazer uma busca por um valor, e obter o dado de outra coluna na mesma tabela; */
public static function obter_dado_de_outro_campo_especifico_valor($tabela,$campo,$valor, $campo_obter_dado)
{
	$dado="";
	self::conectar();
	$sql = "SELECT * FROM {$tabela} WHERE {$campo} = '{$valor}'";
    $res = @mysql_query($sql, self::$connect);
    $row = mysql_fetch_assoc($res);
	$dado = $row[$campo_obter_dado];
	self::fechar();
	return $dado;
}

public static function obter_dados_formulario_e_add($tabela, $array_dos_names_do_formulario)
{
self::conectar();
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
			echo "Campo {$a} vazio.<BR>";
		}else $vars[$a] = $_POST[$a];
	}
}
$flag = self::add($tabela,$campos,$vars);
self::fechar();
return $flag;
}
}

public static function obter_dados_formulario_e_add_UPLOAD_sendo_1_campo($tabela, $array_dos_names_do_formulario)
{
self::conectar();
$campos = $array_dos_names_do_formulario;
if( is_array($array_dos_names_do_formulario) )
{
$vars = array();
$q = 0;
foreach($campos as $a )
{
	if( $q == 0 )
	{
		if( isset($_FILES[$campos[0]]['name']) )
		{
			if( empty($_FILES[$campos[0]]['name']) )
			{
				echo "Campo {$a} vazio.<BR>";
			}else $vars[$a] = $_FILES[$campos[0]]['name'];
		}
		$q++;
	}
	if( isset($_POST[$a]) )
	{
		if( empty($_POST[$a]) )
		{
			echo "Campo {$a} vazio.<BR>";
		}else $vars[$a] = $_POST[$a];
	}
}
$flag = self::add($tabela,$campos,$vars);
self::fechar();
return $flag;
}
}


/* Gerar uma query SQL para criar uma lista de dados através de uma paginação em sql;
inserindo o numero de linhas da consulta a ser retornado(numero de linhas de dados a exibir),
e um numero que serve como contador de cada "pagina" a exibir os dados do banco retornado.
Ex: Exibir de 10 em 10 dados:
consulta_sql_paginacao( <tabela>, 10, 1 ); // <= exibe 10 primeiros dados...
consulta_sql_paginacao( <tabela>, 10, 2 ); // <= exibe mais 10 próximos dados...
consulta_sql_paginacao( <tabela>, 10, 3 ); // <= exibe mais 10 próximos dados...
consulta_sql_paginacao( <tabela>, 10, 4 ); // <= exibe mais 10 próximos dados...
consulta_sql_paginacao( <tabela>, 10, 5 ); // <= exibe mais 10 próximos e assim por diante.
*/
public static function consulta_sql_paginacao($tabela, $numero_linhas_resultado_tabela, $contador_pagina)
{
  /* OFFSET indica o início da leitura;
     LIMIT o máximo de registros a serem lidos; */
  $Q = ($numero_linhas_resultado_tabela*$contador_pagina);
  $sql = "SELECT * FROM {$tabela} LIMIT $numero_linhas_resultado_tabela OFFSET {$Q}";
  return $sql;
}


/*  */
public static function listar_dados($tabela, $array_de_campos, $EDIT = 0, $PESQUISA = NULL/*, $DADO_PESQUISAR = NULL*/)
{
echo "<tr>";
global $arr_colunas_sem_id;
self::conectar();
//mysql_set_charset('utf8',self::$connect);
$campos = $array_de_campos;
//$sql = "SELECT * FROM {$tabela} ORDER BY id ASC";
$nn = (10*$_SESSION["con"]);
$sql = "SELECT * FROM {$tabela} LIMIT {$nn}, 10";
$res = mysql_query($sql,self::$connect)or die(mysql_error());
$ce = 1;
$con = 1;
$flag = false;
while ($row = mysql_fetch_array($res))
{
  echo "<tr>";


  if( (!empty($PESQUISA)) )
  {
    $f = true;
    foreach($campos as $a)
    {
      $NOME = descri_l($row["nome"]);
      if( (@eregi(".*({$PESQUISA}).*", $NOME)) ){

        if($f){ echo "<td>{$con}.</td>"; $con++; $f = false; }

        if(descri_l($row[$a]) == "ok_est_reg"){
          $flag = true;
            echo "<td>OK</td>";
        }
        else if( ($a == "outra_forma_contri") && (descri_l($row["forma_de_contribuicao"]) != "outro") && (!empty(descri_l($row["outra_forma_contri"]))) ){
            echo "<td></td>";
        }
        else{
            $dado = descri_l($row[$a]);
            $id = $row["id"];

            if(strlen($dado) > 15){
              $dado = encurtar_string($dado);
              if( se_get_v("pesquisa") ){
                echo "<td class=\"success\"><a href=\"ass.php?pesquisa={$_GET['pesquisa']}&s={$id}&c={$a}\" class=\"templatemo-link\">{$dado}</a></td>";
              }else{echo "<td class=\"success\"><a href=\"ass.php?s={$id}&c={$a}\" class=\"templatemo-link\">{$dado}</a></td>";}
            }else{
              echo "<td class=\"success\">{$dado}</td>";
            }
        }

        $ultima_coluna = $arr_colunas_sem_id[count($arr_colunas_sem_id)-1];
        if($a == $ultima_coluna){
          echo
          "<!--
          <td><a href=\"\" class=\"templatemo-edit-btn\">Edit</a></td>
          <td><a href=\"\" class=\"templatemo-link\">Action</a></td>
          -->

          <td>
            <a href=\"ass.php?edit={$row['id']}\" class=\"templatemo-edit-btn\">Editar</a>
          </td>
          <td>
            <a href=\"ass.php?del={$row['id']}\" class=\"templatemo-edit-btn\">Deletar</a>
          </td>
          ";
          $f = true;
        }

      }

    }// fim foreach.

  }//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
  else{
    echo "<td>{$ce}.</td>";
  /* se não recebe variavel get para indicar a linha da tabela que deve ser marcada para edição;
  exibe a tabela normal, exibindo todos os dados na tabela. */
  if( $EDIT == 0 )
  {
    	foreach($campos as $a)
    	{
         $nome = descri_l($row["nome"]);

          if(descri_l($row[$a]) == "ok_est_reg"){
            $flag = true;
              echo "<td>OK</td>";
          }
          else if( ($a == "outra_forma_contri") && (descri_l($row["forma_de_contribuicao"]) != "outro") && (!empty(descri_l($row["outra_forma_contri"]))) ){
              echo "<td></td>";
          }
          else{
              $dado = descri_l($row[$a]);
              $id = $row["id"];

              if(strlen($dado) > 15){
                $dado = encurtar_string($dado);
                if( se_get_v("pesquisa") ){
                  echo "<td><a href=\"ass.php?pesquisa={$_GET['pesquisa']}&s={$id}&c={$a}\" class=\"templatemo-link\">{$dado}</a></td>";
                }else{echo "<td><a href=\"ass.php?s={$id}&c={$a}\" class=\"templatemo-link\">{$dado}</a></td>";}
              }else{
                echo "<td>{$dado}</td>";
              }
          }
    	}// fim foreach.

}else{
  /* exibe todos os dados na tabela, com uma diferença na mudança da tabela
  na linha onde foi indicada pela variavel get capturada. */
    if($row['id'] == $EDIT)
    {
        foreach($campos as $a)
        {
            if(descri_l($row[$a]) == "ok_est_reg"){
              $flag = true;
                echo "<td>OK</td>";
            }else{
                echo "<td  class=\"success\">";
                $dado = descri_l($row[$a]);

                  $dado = encurtar_string($dado);
                  echo "<a href=\"ass.php?edit={$row['id']}&cedit={$a}\" class=\"templatemo-link\" >{$dado}</a>";
                  echo "</td>"; //<<< atenção aqui.

            }
        }// fim foreach.
    }else{
      /* exibe todos os dados normalmente que não fazem parte
      da linha informada pela variavel get. */
        foreach($campos as $a)
        {
            if(descri_l($row[$a]) == "ok_est_reg"){
              $flag = true;
                echo "<td>OK</td>";
            }
            else if( ($a == "outra_forma_contri") && (descri_l($row["forma_de_contribuicao"]) != "outro") && (!empty(descri_l($row["outra_forma_contri"]))) ){
                echo "<td></td>";
            }
            else{
                $dado = descri_l($row[$a]);
                $id = $row["id"];

                $quan = 15;
                if(strlen($dado) > $quan){
                  $dado = substr($dado, 0, $quan)."...";
                  echo "<td><a href=\"ass.php?s={$id}&c={$a}\" class=\"templatemo-link\">{$dado}</a></td>";
                }else{
                  echo "<td>{$dado}</td>";
                }
            }
        }// fim foreach.
    }// fim else
}//fim else edit.

  echo
  "<td>
    <a href=\"ass.php?edit={$row['id']}\" class=\"templatemo-edit-btn\">Editar</a>
  </td>
  <td>
    <a href=\"ass.php?del={$row['id']}\" class=\"templatemo-edit-btn\">Deletar</a>
  </td>
  ";
  $ce++;
}
  //<a href=\"ass.php?del={$row['id']}\" class=\"templatemo-edit-btn\">Deletar</a>
  echo "</tr>";
  //<td><a href=\"ass.php?del={$row['id']}\" class=\"templatemo-link\">Deletar</a></td>

}// fim while;

self::fechar();
}

/* retorna um array de array, onde em cada array tem no maximo 10 elementos da busca; */
public static function array_pesquisa($tabela, $array_de_campos, $PESQUISA)
{
global $arr_colunas_sem_id;
self::conectar();

$campos = $array_de_campos;
$sql = "SELECT * FROM {$tabela}";
$res = mysql_query($sql,self::$connect)or die(mysql_error());
$con = 0;
$arr = array(array());
$ind = 0;
while ($row = mysql_fetch_array($res))
{
  if( (!empty($PESQUISA)) )
  {
      $NOME = descri_l($row["nome"]);
      if( (@eregi(".*({$PESQUISA}).*", $NOME)) ){

        if($con < 10){
          array_push($arr[$ind], $row["id"]); // retorna o id;
          $con++;

          if($con == 10){
            $ind++; $con=0;
            array_push($arr, array());
          }
        }
      }
  }
}//fim while;
self::fechar();

  return $arr;
}

public static function exibir_tabela_por_id($tabela, $array_de_campos, $id, $numero_da_linha, $EDIT = 0 )
{
  echo "<tr>";
  global $arr_colunas_sem_id;
  self::conectar();
  $sql = "SELECT * FROM {$tabela} WHERE id = '{$id}'";
  $res = mysql_query($sql,self::$connect)or die(mysql_error());
  while ($row = mysql_fetch_array($res))
  {
    echo "<tr>";
    echo "<td>{$numero_da_linha}.</td>";
    foreach($array_de_campos as $a)
    {
        if(descri_l($row[$a]) == "ok_est_reg"){
          $flag = true;
            echo "<td>OK</td>";
        }
        else if( ($a == "outra_forma_contri") && (descri_l($row["forma_de_contribuicao"]) != "outro") && (!empty(descri_l($row["outra_forma_contri"]))) ){
            echo "<td></td>";
        }
        else{
            if( $EDIT == 0 )
            {
              $dado = descri_l($row[$a]);
              $id = $row["id"];

              if(strlen($dado) > 15){
                $dado = encurtar_string($dado);
                if( se_get_v("pesquisa") ){
                  echo "<td class=\"success\"><a href=\"ass.php?pesquisa={$_GET['pesquisa']}&s={$id}&c={$a}\" class=\"templatemo-link\">{$dado}</a></td>";
                }else{echo "<td class=\"success\"><a href=\"ass.php?s={$id}&c={$a}\" class=\"templatemo-link\">{$dado}</a></td>";}
              }else{
                echo "<td class=\"success\">{$dado}</td>";
              }
            }else{
                echo "<td  class=\"danger\">";
                $dado = descri_l($row[$a]);
                $dado = encurtar_string($dado);
                echo "<a href=\"ass.php?edit={$row['id']}&cedit={$a}\" class=\"templatemo-link\" >{$dado}</a>";
                echo "</td>"; //<<< atenção aqui.
            }
        }

        $ultima_coluna = $arr_colunas_sem_id[count($arr_colunas_sem_id)-1];
        if($a == $ultima_coluna){
          echo"
          <td>
            <a href=\"ass.php?edit={$row['id']}\" class=\"templatemo-edit-btn\">Editar</a>
          </td>
          <td>
            <a href=\"ass.php?del={$row['id']}\" class=\"templatemo-edit-btn\">Deletar</a>
          </td>
          ";
        }
    }// fim foreach.
    echo "</tr>";
  }// fim while;

  self::fechar();
}


public static function listar_dados_PP($tabela, $array_de_campos, $PESQUISA, $indice = 0)
{
  $arr_ids = self::array_pesquisa($tabela, $array_de_campos, $PESQUISA);
  if($indice < count($arr_ids))
  {
    for($i=0; $i<count($arr_ids[$indice]); $i++)
    {
      $id = $arr_ids[$indice][$i];
      self::exibir_tabela_por_id($tabela, $array_de_campos, $id, ($i+1) );
    }
  }

}


public static function gravar_dados($tabela, $array_de_campos)
{
$arquivo = "REGISTROS_ABAPK";
$fd = fopen($arquivo, "w");
fwrite($fd, "-- REGISTRO DE ASSOCIADOS A ABAPK --" . "\n\n");
self::conectar();
//mysql_set_charset('utf8',self::$connect);
$campos = $array_de_campos;
$sql = "SELECT * FROM {$tabela} ORDER BY id ASC";
$res = mysql_query($sql,self::$connect)or die(mysql_error());
$ce = 1;
while ($row = mysql_fetch_array($res))
{
  fwrite($fd, "{$ce}:[" . "\n");
	foreach($campos as $a)
	{
    if(descri_l($row[$a]) == "ok_est_reg"){
      fwrite($fd, "{$a}: OK;" . "\n");
    }
    else if( ($a == "outra_forma_contri") && (descri_l($row["forma_de_contribuicao"]) != "outro") && (!empty(descri_l($row["outra_forma_contri"]))) ){
      fwrite($fd, "{$a}: VAZIO;" . "\n");
    }
    else{
      $dado = descri_l($row[$a]);
      fwrite($fd, "{$a}: {$dado};" . "\n");
    }
	}// fim foreach.
  fwrite($fd, "]" . "\n\n");

  $ce++;
}// fim while;

  chmod($arquivo, 0777);
  $arquivo_zip = "registros-abapk.zip";
  $zip = new ZipArchive();
  if( $zip->open( $arquivo_zip , ZipArchive::CREATE ) === true){
      $zip->addFile( $arquivo , $arquivo );
      $zip->close();
      chmod($arquivo_zip, 0777);
  }

self::fechar();
}

//*************

public static function se_dado_coluna($tabela, $coluna, $DADO)
{
self::conectar();
mysql_set_charset('utf8',self::$connect);
$DADO_ENCONTRADO = false;
$sql = "SELECT {$coluna} FROM {$tabela} ORDER BY id ASC";
$res = mysql_query($sql,self::$connect)or die(mysql_error());
$ce = 0;
while ($row = mysql_fetch_array($res))
{
	if( $row[$coluna] == $DADO ) $DADO_ENCONTRADO = true;
}
self::fechar();
return $DADO_ENCONTRADO;
}

/* ******************************************** */
public static function listar_dados_menu($tabela, $array_de_campos)
{
self::conectar();
mysql_set_charset('utf8',self::$connect);
$campos = $array_de_campos;
$sql = "SELECT * FROM {$tabela} ORDER BY id ASC";
$res = mysql_query($sql,self::$connect)or die(mysql_error());
$ce = 0;
while ($row = mysql_fetch_array($res))
{
	foreach($campos as $a)
	{
		$temp = ucfirst($a);
		echo "<option value='{$row[$a]}'>{$row[$a]}</option>";
	}
}
self::fechar();
}
/* ******************************************** */

}

?>
