<?php include("lib.php");
session_start();
criar_banco_e_senha_adm($banco);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Associação - Associação Baiana de Parkour</title>
    <meta name="description" content="">
    <meta name="author" content="templatemo">
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/templatemo-style.css" rel="stylesheet">


  </head>
  <body>
    <!-- Left column -->
    <div class="templatemo-flex-row">

      <!-- Main content -->
      <div class="templatemo-content col-1 light-gray-bg">
        <div class="templatemo-top-nav-container">
          <div class="row">
            <nav class="templatemo-top-nav col-lg-12 col-md-12">
              <ul class="text-uppercase">
                <li><a href="index.php" class="active">registrar</a></li>
                <li><a href="index.php?id=abapk">abapk</a></li>
                <li><a href="index.php?id=termo">termo de responsabilidade</a></li>
                <li><a href="index.php?id=estatuto">estatuto</a></li>
                <li><a href="index.php?id=regimento">regimento interno</a></li>
                <li><a href="index.php?id=infopag">inf. de pagamento</a></li>
                <!--<li><a href="index.php?id=voltar">voltar ao site</a></li>-->
              </ul>
            </nav>
          </div>
        </div>


        <div class="templatemo-content-container">
          <div class="templatemo-content-widget white-bg">

            <? if( (!se_get()) ) {?>
            <h2 class="margin-bottom-10">Registro de Associação</h2>
            <!--<p><b>( </b><font color='red'>*</font><b> )</b> <font color='red'>Campos obrigatórios</font>.</p>-->
            <p>Formulário de registro na Associação Baiana de Parkour - ABAPK.</p>

            <form action="index.php" id="cad" class="templatemo-login-form" method="post">
              <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputFirstName">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="">
                </div>
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputLastName">Data de nascimento</label>
                    <input type="text" class="form-control" id="data" name="data" placeholder="">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputUsername">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" placeholder="">
                </div>
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputUsername">Celular</label>
                    <input type="text" class="form-control" id="celular" name="celular" placeholder="">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputFirstName">Cidade</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade onde você reside.">
                </div>
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputLastName">UF/ESTADO</label>
                    <input type="text" class="form-control" id="uf" name="uf" placeholder="">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputFirstName">RG</label>
                    <input type="text" class="form-control" id="rg" name="rg" placeholder="">
                </div>
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputLastName">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputLastName">CEP</label>
                    <input type="text" class="form-control" id="cep" name="cep" placeholder="">
                </div>
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <BR>
                    <label for="inputFirstName">Filiação:</label>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputFirstName">Pai</label>
                    <input type="text" class="form-control" id="pai" name="pai" placeholder="">
                </div>
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputLastName">Mãe</label>
                    <input type="text" class="form-control" id="mae" name="mae" placeholder="">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <BR>
                    <label for="inputFirstName">Forma de Contribuição:</label>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-lg-12 form-group">
                    <div class="margin-right-15 templatemo-inline-block">
                      <input type="radio" name="radio" id="r7" value="trimestral">
                      <label for="r7" class="font-weight-400"><span></span>Trimestral ( R$ 10,00 )</label>
                    </div>
                    <div class="margin-right-15 templatemo-inline-block">
                      <input type="radio" name="radio" id="r5" value="semestral">
                      <label for="r5" class="font-weight-400"><span></span>Semestral ( R$ 20,00 )</label>
                    </div>
                    <div class="margin-right-15 templatemo-inline-block">
                      <input type="radio" name="radio" id="r4" value="anual">
                      <label for="r4" class="font-weight-400"><span></span>Anual ( R$ 40,00 )</label>
                    </div>
                    <div class="margin-right-15 templatemo-inline-block">
                      <input type="radio" name="radio" id="outro" value="outro">
                      <label for="outro" class="font-weight-400"><span></span>Outro</label>
                    </div>
                </div>
              </div>

              <script src="form.js"></script>

              <div id="outra_forma">
                <div class="row form-group">
                  <div class="col-lg-6 col-md-6 form-group">
                      <label for="inputFirstName">Informe a outra forma de contribuição</label>
                      <input type="text" class="form-control" id="outra_forma_contri" name="outra_forma_contri" placeholder="">
                  </div>
                </div>
                <BR>
              </div>


              <div class="row form-group">
                <div class="col-lg-12 form-group">
                    <div class="margin-right-15 templatemo-inline-block">
                      <input type="checkbox" name="concordo" id="c3" value="ok_est_reg">
                      <label for="c3" class="font-weight-400"><span></span>Concordo com o Estatuto e o Regimento interno.</label>
                    </div>
                    <div class="margin-right-15 templatemo-inline-block">
                      <label for="c33" class="font-weight-400"><span></span><b>(</b> Leia o <a href="index.php?id=estatuto" target="_blank">Estatuto</a> e o <a href="index.php?id=regimento" target="_blank">Regimento Interno</a> <b>)</b></label>
                    </div>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-lg-12 form-group">
                    <label class="control-label" for="inputNote">Informações adicionais / Comentários (Opcional)</label>
                    <textarea class="form-control" id="info" name="info" rows="3"></textarea>
                </div>
              </div>


              <div class="form-group text-right">
                <button type="submit" class="templatemo-blue-button">enviar registro</button>
              </div>
            </form>


            <? }//fim if
                else if(se_get() && ($_GET["id"] == "estatuto") ){
                  ler_txt("docs/estatuto");
                  sair_reg();
                }
                else if(se_get() && ($_GET["id"] == "regimento") ){
                  ler_txt("docs/regimento-interno");
                  sair_reg();
                }
                else if(se_get() && ($_GET["id"] == "abapk") ){
                  ler_txt("docs/abapk");
                  sair_reg();
                }
                else if(se_get() && ($_GET["id"] == "termo") ){
                  echo "<a href='termo-de-tesponsabilidade-abapk.doc'>Download</a> do Termo de Responsabilidade.";
                  sair_reg();
                }
                else if(se_get() && ($_GET["id"] == "infopag") ){
                  echo $info_pagamento;
                }
                else if(se_get() && ($_GET["id"] == "reg") && (se_registro()) ){

                  echo "<font color='blue'><b>Cadastro enviado com sucesso.</b></font><BR><BR>
                        Quase lá, companheiro de muros! <BR>
                        Logo abaixo segue as informações sobre como realizar o primeiro pagamento. <BR>
                        E logo poderá se considerar um membro da <b>Associação Baiana de Parkour</b>. <BR>
                        <font color='blue'><b>;)</b></font>
                        <BR><BR>
                        <b>Até!</b>
                        <BR><BR>—————<BR><BR>";

                  echo $info_pagamento;
                  echo "<BR><b>(Esta informação também pode ser acessada através do menu superior.)</b>";

                        sair_reg();

                }else{
                  redirecionar("index.php"); // se não registrado e acessar a pagina: index.php?id=reg
                }


                $arr_names = array("nome","data","telefone","celular","cidade","uf","rg","cpf",
                "cep","email","pai","mae","radio","outra_forma_contri","concordo","info");
                $dados = obter_dados_formulario($arr_names);
                $conteudos_campos = array();

                if( (!empty($dados)) )
                {
                  /* --\/-- ordena alguns dados do array para inseri-los no banco de dados,
                    colocar valores nulo no array onde é permitido um campo vazio, para o array
                    ficar de comprimento igual ao numero de colunas da tabela.
                  */
                  for($a=0; $a<count($arr_names); $a++)
                  {
                      $name = $arr_names[$a];
                        if(!isset($dados[$name])){ //os campos opcionais ficam com valor nulo.
                          $dados[$name] = "";
                        }
                      //echo ($a+1).": ".$name ."=>". $dados[$name]."<BR>";
                      array_push($conteudos_campos, encri_l($dados[$name]));
                  }
                  // --/\--

                  array_push($conteudos_campos, encri_l(data_hora()));
                  array_push($conteudos_campos, encri_l("inativo"));
                  // adicionar dados ao banco aqui.
                  if( $banco->add("associados", $arr_colunas_sem_id, $conteudos_campos) )
                  {
                      $reg = "reg";
                      $_SESSION[$reg] = true;
                      redirecionar("index.php?id=reg");
                  }else{
                      echo "<font color='red'>Erro ao cadastrar.</font><BR>";
                  }

                  /*for($a=0; $a<count($arr_names); $a++){
                      $name = $arr_names[$a];
                        if(!isset($dados[$name])){ //os campos opcionais ficam com valor nulo.
                          $dados[$name] = "";
                        }
                      $en = encri_l($dados[$name]);
                      $de = descri_l($en);
                      echo ($a+1).": ".$name ."=>". $de.": ".strlen($de)."<BR>";
                  }*/

                }// fim if.

            ?>

          </div>
          <footer class="text-right">
            <p>Copyright &copy; 2015 Associação Baiana de Parkour
            | ABAPK </p>
          </footer>
        </div>
      </div>
    </div>

    <a href="javascript:;" id="aviso" data-toggle="modal" data-target="#confirmModal"></a>

    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <!-- DIALOG -->
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" id="fechar" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">* Preencha todos os campos.</h4><BR>
            * Caso tenha selecionado a opção "Outro" como <b>forma de contribuição</b>, informe no campo abaixo do mesmo,
            qual a outra forma de contribuição. <BR><BR>
            * Você deverá concordar com o <b>Estatuto</b> e o <b>Regimento Interno</b> da Associação.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>


    <!-- JS -->
    <script src="boot_dialog/js/jquery.min.js"></script>
    <script src="boot_dialog/js/bootstrap.min.js"></script>
    <script src="boot_dialog/js/Chart.min.js"></script>
    <script src="boot_dialog/js/templatemo_script.js"></script>

    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-filestyle.min.js"></script>
    <script type="text/javascript" src="js/templatemo-script.js"></script>
  </body>
</html>
