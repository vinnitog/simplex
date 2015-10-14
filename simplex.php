<?php

if (isset($_POST['fo'])) 
	{
   		$fo = $_POST ['fo'];     
	}

if (isset($_POST['maximizar_minimizar'])) {
  $max_min = $_POST ['maximizar_minimizar'];
	}

	if ($max_min == 'maximizar') {
			$choice_type = $max_min;
		}
	if ($max_min == 'minimizar') {
			$choice_type = $max_min;
		}

if (isset($_POST['menor_maior'])) {
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
	<script src="js/jquery-2.1.4.js"></script>
</head>
<body>
<h1 class="text-center">Simplex</h1>

<div class="container" id="general">
	<div class="container">
		<div class="row">
			<form action="simplex.php" method="post">
			    <div class="form-group">
				    <label>Função Objetiva:</label>
				    <input type="text" name="fo" class="form-control" id="fo" placeholder="Função Objetiva">
			    </div>
		</div>
		<label class="row">Restrições:</label>
		<div class="row">
	    	<div class="col-md-2" id="edit_rest">
			    <input id="align_rest" type="text" name="rest" class="form-control" id="rest" placeholder="Restrições">
			</div>
			<div class="col-md-2">
			    <select id="align_signal" class ="form-control" name="menor_maior">
				  <option name="menor" value="menor_igual"> <= </option>
				  <option name="maior" value="maior_igual"> >= </option>
		  		</select>
				</div>
	  		<div class="col-md-2">
			    <input id="align_resource" type="text" name="resource" class="form-control" id="resource" placeholder="Recursos">
			</div>
			<div class="col-md-2">
				<input id="add" name="add" type="submit" value="Adicionar" class="btn btn-success">
			</div>
		</div><br>
		<div class="row">
			<div class="col-md-2" id="edit_rest">
				<?php
				
					$rest_add = [];
					if (isset($_POST['add'])) 
					{
						for ($i=0; $i <=4; $i++) 
							{ 	
								if ($i == 0)
								{
									$rest_add[$i] = $_POST ['rest'].$_POST ['menor_maior'].$_POST ['resource'];
									?>
								 	<input id="align_rest" type="text" name="add" class="form-control" id="rest" placeholder="Restrições" value= <?php echo $rest_add[$i] ?>>
									<?php
									var_dump($i);
								}
								else if ($i == 1)
								{
									$rest_add[$i] = $_POST ['rest'].$_POST ['menor_maior'].$_POST ['resource'];
									?>
								 	<input id="align_rest" type="text" name="add" class="form-control" id="rest" placeholder="Restrições" value= <?php echo $rest_add[$i] ?>>
									<?php
									var_dump($i);	
								}
								else if ($i == 2)
								{
									$rest_add[$i] = $_POST ['rest'].$_POST ['menor_maior'].$_POST ['resource'];
									?>
								 	<input id="align_rest" type="text" name="add" class="form-control" id="rest" placeholder="Restrições" value= <?php echo $rest_add[$i] ?>>
									<?php
									var_dump($i);	
								}
								else if ($i == 3)
								{
									$rest_add[$i] = $_POST ['rest'].$_POST ['menor_maior'].$_POST ['resource'];
									?>
								 	<input id="align_rest" type="text" name="add" class="form-control" id="rest" placeholder="Restrições" value= <?php echo $rest_add[$i] ?>>
									<?php
									var_dump($i);	
								}
								else
								{								
									$rest_add[$i] = $_POST ['rest'].$_POST ['menor_maior'].$_POST ['resource'];
									?>
								 	<input id="align_rest" type="text" name="add" class="form-control" id="rest" placeholder="Restrições" value= <?php echo $rest_add[$i] ?>>
									<?php
									var_dump($i);	
								}
								
								
							}
					}
				?>
			</div>
		</div><br>
		<div class="row">
			<select id="align_most" class ="form-control" name="maximizar_minimizar">
			  <p>Escolha maximizar ou minimizar:</p>
			  <option name="max" value="maximizar">Maximizar</option>
			  <option name="min" value="minimizar">Minimizar</option>
		  	</select><br>
		  	<input name="enviar" type="submit" value="Enviar" class="btn btn-success"><br><br>
		</div>
		<div class="row">
		  <label>Expressão:</label>
		  <input type="text" name="result" class="form-control" value =  
		  	<?php
		  		if (isset($_POST['enviar'])) {
		  		 	foreach ($expression as $key => $value) { //[$key] indicaria a posição de cada value ficaria "[$key] => value";
					$express = "$value";
					echo $express;
					}
		  		 } 
		  		 
			?>>
		</div><br>
		<div class="row">
			<label>Modo Escolhido:</label>
			<input id="align_most" type="text" name="result" class="form-control" value=  <?php echo $choice_type; ?> >
		</div><br>
		<div class="row">
			<label>Sinal Escolhido:</label>
			<input id="align_most" type="text" name="result" class="form-control" value=  <?php echo $choice_signal; ?> >
		</div><br>
			  	<div class="row">
				  	<div class="container" id="edit_rest">
					  	<table class="table table-bordered">
					  		<tr name="table_row">
					  		<?php
								$i = 0;
								foreach ($expression as $key => $value) {
									$i++;
									print '<td>'.$value.'</td>';
									if ($i % 3 == 0){
					            		print '</tr><tr>';
					        		}
								}
							?>
							<!--
							  <td name="base" class="danger" value= <?php //echo $base?> >Base</td>
							  <td class="success">2</td>
							  <td class="success">3</td>
							  <td class="success">4</td>
							  <td name="b" class="danger" value= <?php //echo $b?> >b</td>-->
							</tr>
						</table>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<br>

<p>Click the button to display an alert box:</p>

<button onclick="myFunction()">Try it</button>

<script>
function myFunction() {
    //alert("I am an alert box!");
   
}
</script>
</body>


</html>