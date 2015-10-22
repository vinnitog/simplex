<?php

$function_objective = isset($_POST['fo']);
$maximizer_minimizer = isset($_POST['maximizar_minimizar']);
$small_large = isset($_POST['menor_maior']);
$resource = $_POST ['resource'];
$rest = $_POST ['rest'];
$qtd_vd = $_POST['qtd_vd'];
$qtd_rest = $_POST['qtd_rest'];
$continue = isset($_POST['continue']);
$rest_add = $rest.$menor_maior.$resource; //importante!
$enviar = isset($_POST['enviar']);

if ($function_objective) {
	$fo = $_POST ['fo'];
}

if ($maximizer_minimizer) {
 	$max_min = $_POST ['maximizar_minimizar'];
}

	if ($max_min == 'maximizar') {
			$choice_type = $max_min;
		}
	if ($max_min == 'minimizar') {
			$choice_type = $max_min;
		}

if ($small_large) {
  	$menor_maior = $_POST ['menor_maior'];
}

	if ($menor_maior == 'menor_igual') {
			$choice_signal = $menor_maior;
		}
	if ($menor_maior == 'maior_igual') {
			$choice_signal = $menor_maior;
		}

$expression = str_split($fo);
?>


<!DOCTYPE html>
<html>
<head>
	<title>Simplex</title>
	<meta charset ="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<h1 class="text-center">Simplex</h1>

<div class="container" id="general">
	<div class="container">
		<div class="row"><br>
			<form class="form-inline" action="simplex.php" method="post">
			    <div class="form-group">
				    <label>Informe a quantidade de variáveis de decisão:</label>
				    <input type="number" name="qtd_vd" class="form-control" value=<?php echo "\"$qtd_vd\""?>>
			    </div>
			    <div class="form-group">
				    <label>Informe a quantidade de restrições:</label>
				    <input type="number" name="qtd_rest" class="form-control" value=<?php echo "\"$qtd_rest\""?>>
			    </div>
			    <button class="btn btn-success" name="continue">Continuar</button>
			</form>
		</div><br>
		<div class="row">
			<form class="form-inline" action="simplex-algoritmo.php" method="post">
				<?php
					echo "<label>Função Objetiva:</label><br>";
					for ($i=0; $i<$qtd_vd; $i++) 
					{
						echo "<div class=\"form-inline\">
								<input type=\"text\" name=\"objetivo[]\" class=\"form-control id=\"fo\"> X".($i+1).
		    				  "</div>";

					}
					echo "<br><br><label>Restrições:</label><br>";
					for ($i=0; $i<$qtd_rest; $i++) 
					{
						echo "
						<div class=\"form-inline\">
							<input type=\"text\" name=\"restricao[]\" class=\"form-control\"> X".($i+1).
							"    <=    
							<input type=\"text\" name=\"recurso[]\" class=\"form-control\" id=\"resource\" placeholder=\"Recursos\">
						</div>";		  	
					}
				?>

				<?php

					if ($enviar) 
					{
						echo "<label>Variaveis de Folga e Excesso:";

						for ($i=0; $i<$qtd_rest; $i++) 
						{ 
							echo '<input>X'.$i.'+'.'F'.$i.'</input>'.$resource;		
						}	
					}
				?>
				<br><br>
				<div class="row">
					<select id="align_most" class ="form-control" name="maximizar_minimizar">
					  <p>Escolha maximizar ou minimizar:</p>
					  <option name="max" value="maximizar">Maximizar</option>
				  	</select><br><br>
				  	<input name="enviar" type="submit" value="Enviar" class="btn btn-success"><br><br>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>

</body>
<script src="js/jquery-2.1.4.js"></script>
</html>