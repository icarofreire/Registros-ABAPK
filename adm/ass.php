<?php include("../lib.php");
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
    <script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/templatemo-style.css" rel="stylesheet">


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
                <li><a href="ass.php" class="active">lista de associados</a></li>
                <!--<li><a href="ass.php?id=procurar">pesquisar associado</a></li>-->
                <li><a href="ass.php?id=tsen">trocar senha</a></li>
                <li><a href="ass.php?id=baixar">baixar registros</a></li>
                <li><a href="ass.php?id=sair">sair</a></li>
              </ul>
            </nav>
          </div>
        </div>


        <div class="templatemo-content-container">
          <div class="templatemo-content-widget white-bg">

            <? if(!se_get()){ /* <= O campo de busca somente ser visualizado na pagina inicial. */ ?>
            <div class="btn-group pull-right" id="templatemo_sort_btn">
              <form class="navbar-form" action="ass.php" method="get">
                <input type="text" name="pesquisa" class="form-control" id="templatemo_search_box" placeholder="Pesquisar por nome...">
                <button type="submit" class="btn btn-default">Ir</button>
              </form>
            </div>
            <? }
            /* fez uma pesquisa, o contador de paginação vai logo para a 1º pagina. */
            if( se_get_v("pesquisa") && (!se_get_v("prox")) ){
              $_SESSION["con"] = 0;
            }
            ?>

            <? if( (!se_get()) && se_logado() ) {
                $f_index = true;
            ?>
            <h2 class="margin-bottom-10">Lista de Associados</h2>
            <p>Lista de Associados na Associação Baiana de Parkour - ABAPK |
            <?
              $numero_ass = $banco->numero_registros("associados");
              echo "( <b>{$numero_ass}</b> Pessoas Associadas. )";

              if( se_get_v("prox") && ($_GET["prox"] == '1') ){
                if( (($_SESSION["con"]+1)*10) < $numero_ass ){
                  $_SESSION["con"]++;
                }
              }else if( se_get_v("prox") && ($_GET["prox"] == '-1') ){
                if($_SESSION["con"] > 0){
                  $_SESSION["con"]--;
                }
              }
              $ntab = $_SESSION['con']+1;
              echo " | Tab: {$ntab}.";
            ?>
            </p>

            <!-- tabela -->
            <div class="templatemo-content-widget no-padding">
              <div class="panel panel-default table-responsive">
                <table class="table table-striped table-bordered templatemo-user-table table-hover">
                  <thead>
                    <tr>
                      <td>#</td>
                      <? for($a=0; $a<count($arr_colunas_sem_id); $a++){
                            echo "<td>{$titulos_tabela[$arr_colunas_sem_id[$a]]}</td>";
                          }
                      ?>
                      <td>Editar</td>
                      <td>Deletar</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?
                        $off = -1;
                        $EDIT = 0;
                        if( se_get_v("edit") ){
                          $EDIT = $_GET["edit"];
                        }
                        if( !se_get_v("pesquisa") ){
                          if($EDIT == 0){ // <- não pesquisou, e não clicou em editar;
                            $banco->listar_dados("associados", $arr_colunas_sem_id);
                          }else{// <- não pesquisou, mas clicou para editar;
                            $banco->exibir_tabela_por_id("associados", $arr_colunas_sem_id, $EDIT, 1, $EDIT);
                          }
                        }else{

                          if($EDIT == 0){// <- feito uma pesquisa, e não clicou em editar;
                            $banco->listar_dados_PP("associados", $arr_colunas_sem_id, $_GET["pesquisa"], $_SESSION['con']);
                          }else{// <- feito uma pesquisa, mas clicou para editar;
                            $banco->exibir_tabela_por_id("associados", $arr_colunas_sem_id, $EDIT, 1, $EDIT);
                          }

                        }

                    ?>
                  </tbody>

                </table>
              </div>
            </div>
            <!-- tabela -->


            <?

            if( se_get_v("edit") && se_get_v("cedit") ){
                $coluna = $_GET["cedit"];
                $id = $_GET["edit"];
                $cc = descri_l($banco->obter_dado_do_campo_especifico("associados", $coluna, $id));

                  echo
                  "<BR>
                  <form action=\"ass.php?edit={$id}&cedit={$coluna}\" class=\"templatemo-login-form\" method=\"post\" >
                    <div class=\"form-group\">
                      <label for=\"inputEmail\">{$titulos_tabela[$coluna]}</label>
                      <input type=\"text\" class=\"form-control\" name=\"editar_celula\" id=\"\" value=\"{$cc}\">
                    </div>
                    <div class=\"form-group\">
                      <button type=\"submit\" class=\"templatemo-blue-button\">Alterar</button>
                    </div>
                  </form>";


                  $dados = obter_dados_formulario(array("editar_celula"));
                  if( (!empty($dados)) ){
                      $novo_dado_celula = encri_l($dados["editar_celula"]);
                      if( $banco->mod("associados", $coluna, $id, $novo_dado_celula) ){
                        echo "<script>
                              alert('Alteração realizada com sucesso.');
                              </script>";
                        redirecionar("ass.php?edit={$id}");
                      }
                  }
            }

            ?>




            <?

            if( se_logado() && se_get_v("s") && se_get_v("c") ){
              echo
              "<script>
                jQuery(document).ready(function() {
                  document.getElementById('exibe').click();
                });
              </script>";
            }

            }//fim if
                else if(se_get() && se_logado() && ($_GET["id"] == "sair") ){
                  echo "Saindo do sistema...";
                  unset($_SESSION["con"]); //destroi contador de paginas da tabela;
                  deslogar();
                }
                else if(se_get() && se_logado() && ($_GET["id"] == "tsen") ){
                  echo
                  "<div class=\"panel panel-default margin-10\">
                    <div class=\"panel-heading\"><h2 class=\"text-uppercase\">trocar senha do sistema</h2></div>
                    <div class=\"panel-body\">
                      <form action=\"ass.php?id=tsen\" class=\"templatemo-login-form\" method=\"post\">
                        <div class=\"form-group\">
                          <label for=\"inputEmail\">Senha atual</label>
                          <input type=\"password\" name=\"senha_atual\" class=\"form-control\" id=\"inputEmail\" placeholder=\"\">
                        </div>
                        <div class=\"form-group\">
                          <label for=\"inputEmail\">Nova senha</label>
                          <input type=\"password\" name=\"nova_senha\" class=\"form-control\" placeholder=\"\">
                        </div>
                        <div class=\"form-group\">
                          <label for=\"inputEmail\">Repita a nova senha</label>
                          <input type=\"password\" name=\"rep_nova_senha\" class=\"form-control\" placeholder=\"\">
                        </div>

                        <div class=\"form-group\">
                          <button type=\"submit\" class=\"templatemo-blue-button\">enviar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                  ";

                  $dados = obter_dados_formulario(array("senha_atual","nova_senha","rep_nova_senha"));
                  if( (!empty($dados)) ){
                      $senha_banco = descri_l($banco->obter_dado_do_campo_especifico("senha_adm", "senha", 0));
                      $senha_atual = $dados["senha_atual"];
                      $nova_senha = $dados["nova_senha"];
                      $rep_nova_senha = $dados["rep_nova_senha"];

                      if( $nova_senha == $rep_nova_senha ){
                          if( $senha_atual == $senha_banco ){
                            if( $banco->mod("senha_adm", "senha", 0, encri_l($nova_senha)) ){
                              echo "<font color='blue'><b>Senha alterada com sucesso.</b></font>";
                            }
                          }else{
                            echo "<font color='red'><b>Senha incorreta.</b></font>";
                          }
                      }else{
                        echo "<font color='red'><b>Senhas incompatíveis.</b></font>";
                      }
                  }

                }
                else if(se_get() && se_logado() && ($_GET["id"] == "baixar") ){
                  echo "<a href='ass.php?id=baixar&d=1'>Download</a> dos registros.";
                  if( se_get_v("d") ){
                    $banco->gravar_dados("associados", $arr_colunas_sem_id);
                    $arquivo_zip = "registros-abapk.zip";

                    // Envia o arquivo para o cliente
                    header('Content-type: application/zip');
                    header('Content-disposition: attachment; filename="'.basename($arquivo_zip).'";');
                    header("Content-Transfer-Encoding: binary");
                    header('Content-Length: '.filesize($arquivo_zip));
                    readfile($arquivo_zip);
                    // Envia o arquivo para o cliente

                  }
                }
                else if( se_logado() == false ){
                  redirecionar("index.php");
                }
                else{
                  redirecionar("index.php"); // se não registrado e acessar a pagina: index.php?id=reg
                }

                if( se_get_v("del") && ($_GET["del"][0] != '_' ) ){
                  echo
                  "<script>
                  jQuery(document).ready(function() {
                    document.getElementById('aviso').click();
                  });
                  </script>
                  ";
                }
                else if( se_get_v("del") && ($_GET["del"][0] == '_' ) ){
                    $nd = "";
                    $d = $_GET["del"];
                    for($a=1; $a<strlen($d); $a++){
                      $nd .= $d[$a];
                    }

                    // deletar aqui, o id na tabela escolhido é: "$nd";
                    if( $banco->excluir_por_id("associados", $nd) ){
                      redirecionar("ass.php");
                    }

                }


            ?>

          </div>

          <? if( (isset($f_index)) && $f_index ){ ?>
          <div class="pagination-wrap">
            <ul class="pagination">
              <?
                /* se feito uma pesquisa, a pesquisa continua com a paginação da tabela. */
                if( se_get_v("pesquisa") ){
                  echo
                  "<li><a href=\"ass.php?pesquisa={$_GET['pesquisa']}&prox=-1\" id=\"anterior\"><< anterior</a></li>
                   <li><a href=\"ass.php?pesquisa={$_GET['pesquisa']}&prox=1\" id=\"proximo\">próximo >></a></li>";
                }else{
                  echo
                  "<li><a href=\"ass.php?prox=-1\" id=\"anterior\"><< anterior</a></li>
                   <li><a href=\"ass.php?prox=1\" id=\"proximo\">próximo >></a></li>";
               }
              ?>
            </ul>
          </div>
          <? } ?>

          <footer class="text-right">
            <p>Copyright &copy; 2015 Associação Baiana de Parkour
            | ABAPK </p>
          </footer>
        </div>
      </div>
    </div>

    <a href="javascript:;" id="aviso" data-toggle="modal" data-target="#confirmModal"></a>
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" id="fechar" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Você tem certeza ?</h4><BR>
            Deseja realmente deletar este registro do banco de dados ?
          </div>
          <div class="modal-footer">
            <?
                echo "<a href=\"ass.php?del=_{$_GET['del']}\" class=\"btn btn-primary\">SIM</a>";
            ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">NÃO</button>
          </div>
        </div>
      </div>
    </div>

    <!-- %%%%% -->

    <a href="javascript:;" id="exibe" data-toggle="modal" data-target="#exibedado"></a>
    <div class="modal fade" id="exibedado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" id="fechar" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel"><? echo $titulos_tabela[$_GET["c"]]; ?>:</h4><BR>
            <?
              $dd = $banco->obter_dado_do_campo_especifico("associados", $_GET["c"], $_GET["s"]);
              if( !empty($dd) ){
                $d = descri_l($dd);

                $con_c = 0;
                for($i=0; $i<strlen($d); $i++){
                  if($con_c == 80){
                    $d[$i]="\n";
                    $con_c = 0;
                  }
                  $con_c++;
                }
                echo $d;
              }
            ?>
          </div>
          <div class="modal-footer">
            <!--<a href="ass.php" class="btn btn-default">OK</a>-->
            <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
    <!-- %%%%% -->


    <a href="javascript:;" id="editar" data-toggle="modal" data-target="#editar_dados"></a>
    <div class="modal fade" id="editar_dados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" id="fechar" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Editar</h4><BR><BR>

              <form action="index.html" class="templatemo-login-form">
                <div class="form-group">
                  <label for="inputEmail">Email address</label>
                  <input type="email" class="form-control" id="inputEmail" placeholder="Enter email">
                </div>
                <div class="form-group">
                  <label for="inputEmail">Password</label>
                  <input type="password" class="form-control" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <div class="checkbox squaredTwo">
                        <label>
                          <input type="checkbox"> Remember me
                        </label>
                    </div>
                </div>
                <div class="form-group">
                  <button type="submit" class="templatemo-blue-button">Submit</button>
                </div>
              </form>

          </div>
          <div class="modal-footer">
            <a href="ass.php" class="btn btn-default">OK</a>
          </div>
        </div>
      </div>
    </div>



    <!-- JS -->
    <script src="adm.js"></script>
    <script src="../boot_dialog/js/jquery.min.js"></script>
    <script src="../boot_dialog/js/bootstrap.min.js"></script>
    <script src="../boot_dialog/js/Chart.min.js"></script>
    <script src="../boot_dialog/js/templatemo_script.js"></script>

    <script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap-filestyle.min.js"></script>
    <script type="text/javascript" src="../js/templatemo-script.js"></script>
  </body>
</html>
