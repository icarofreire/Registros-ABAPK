<?php

include("lib.php");

/* gerar um nome aleatorio para arquivos e pastas; */
function gerar_nome($tamanho){
	$alfa1 = "abcdefghijklmnopqrstuvwxyz ";
	$nome = "";
	for($i=0; $i<$tamanho; $i++){
    $nome .= $alfa1[rand(0, strlen($alfa1)-1)];
	}
	return $nome;
}

function add_ale($numero){
		$f = false;
    global $banco, $arr_colunas_sem_id;

    for($i=0; $i<$numero; $i++){
      $arf = array("trimestral","semestral","anual","outro");
      $ale = $arf[rand(0,count($arf)-1)];

      $arr = array(
			encri_l(gerar_nome(100)),encri_l(gerar_nome(20)),encri_l(gerar_nome(20)),encri_l(gerar_nome(20)),
			encri_l(gerar_nome(20)),encri_l(gerar_nome(20)),encri_l(gerar_nome(20)),encri_l(gerar_nome(20)),
			encri_l(gerar_nome(20)),encri_l(gerar_nome(10)."@".gerar_nome(5).".com"),
			encri_l(gerar_nome(20)),encri_l(gerar_nome(20)),encri_l($ale),encri_l(gerar_nome(20)),
			encri_l("ok_est_reg"),encri_l(gerar_nome(40)), encri_l(data_hora()), encri_l("inativo")
			);

      if( $banco->add("associados", $arr_colunas_sem_id, $arr) ){
					$f = true;
      }
    }
		if($f){echo "Ok: {$numero} Registros adicionados.<BR>";}
}


//$n_lop_por10 = (((int)($banco->numero_registros("associados")/10))+1);
//echo $n_lop_por10."<BR>";


// adicionar registros automaticamente.
//add_ale(75);

include("enviar_email.php");
$email = new enviar_email("icarofre99@gmail.com");
if($email->enviar("teste")){
	echo "OK, email enviado.";
}else{ echo "erro ao enviar email."; }

?>
