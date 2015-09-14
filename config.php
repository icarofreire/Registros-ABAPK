<?php

/* definições de acesso ao banco de dados; */
define("SERVIDOR", "localhost");//mysql.hostinger.com.br
define("USUARIO", "root");//u475323160_abapk
define("SENHA_DO_BANCO", "");//abapk5964
define("NOME_DO_BANCO", "registro_abapk");//u475323160_reg


/* senha inicial do adm; */
define("SENHA_ADM", "abapk_9537");

/* colunas para o link de editar; */
$arr_colunas_editar = array("nome","data_de_nascimento","telefone","celular","cidade","uf","rg","cpf",
"cep","email","pai","mae","forma_de_contribuicao","outra_forma_contri","comentario");


include("classes/banco.php");/* classe de banco de dados; */
include("classes/log.php");/* classe de log; */
include_once("classes/cripto/main.php");/* classe de criptografia; */

/* objeto da classe de banco de dados; */
$banco = new banco(SERVIDOR, USUARIO, SENHA_DO_BANCO, NOME_DO_BANCO);

/* Informações de Pagamento; */
$info_pagamento = "Informações de Pagamento.<BR><BR>
      Conta do Tesoureiro: Paulo Celso da Cruz Júnior.<BR>
      Conta Itaú - AG 7689 CTA 05415-8.<BR>
      Na operação do depósito, deve ser colocado conta 054158/500.";

?>
