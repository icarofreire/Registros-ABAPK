<?php include("../lib.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>Adm</title>
        <meta name="description" content="">
        <meta name="author" content="templatemo">

	    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
	    <link href="../css/font-awesome.min.css" rel="stylesheet">
	    <link href="../css/bootstrap.min.css" rel="stylesheet">
	    <link href="../css/templatemo-style.css" rel="stylesheet">

	</head>
	<body class="light-gray-bg">
		<div class="templatemo-content-widget templatemo-login-widget white-bg">
			<header class="text-center">
	          <div class="square"></div>
	          <h1>adm registro abapk</h1>
	        </header>
	        <form action="index.php" class="templatemo-login-form" method="post">
	        	<div class="form-group">
	        		<div class="input-group">
		        		<div class="input-group-addon"><i class="fa fa-key fa-fw"></i></div>
		              	<input type="password" name="senha" class="form-control" placeholder="******">
		          	</div>
	        	</div>
	          	<div class="form-group">

				</div>
				<div class="form-group">
					<button type="submit" class="templatemo-blue-button width-100">entrar</button>
				</div>
	        </form>
		</div>
		<?php

		$dados = obter_dados_formulario(array("senha"));
		if( (!empty($dados)) ){
				$senha = $dados["senha"];
				$senha_banco = $banco->obter_dado_do_campo_especifico("senha_adm", "senha", 0);
				if( descri_l($senha_banco) == $senha ){
						$_SESSION["log"] = true;
						$_SESSION["con"] = 0;
						redirecionar("ass.php");
				}else{
						echo "
						<div class=\"templatemo-content-widget templatemo-login-widget templatemo-register-widget white-bg\">
						<p><strong><font color='red'>Senha incorreta</font></strong></p>
						</div>";
				}
		}


		?>
		<!--
		<div class="templatemo-content-widget templatemo-login-widget templatemo-register-widget white-bg">
			<p>Not a registered user yet? <strong><a href="#" class="blue-text">Sign up now!</a></strong></p>
		</div>
	  -->
	</body>
</html>
