<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<title>Simplex</title>
</head>
<body>
	<?php 
	if(!isset($_POST['funcao']) && !isset($_POST['sujeito']) && !isset($_POST['sujeito2']) && !isset($_POST['sujeito']) && !isset($_POST['qtdemaxima']))
	{
		echo "entrada incorreta";
		die;
	}
	
	$funcao = $_POST['funcao'];
	$sujeito = $_POST['sujeito'];
	$regraselementovalor = $_POST['sujeito2'];//o array final das regras(resultado <=)
	$qtdemaxima = $_POST['qtdemaxima'];
	$somenteresultado = false;
	if(isset($_POST['somenteresultado']))
		$somenteresultado = true;
	
	/////////////////////////////////////////////////
	//PRINTA INICIO:
	echo "<br/>";
	echo "<h1 class=\"text-center\">Dados Estabelecidos</h1>";
	
	PrintaInicio($funcao, $sujeito, $regraselementovalor, $qtdemaxima);
	/////////////////////////////////////////////////
	
	$arraytabela; // tabela 2d, representa a tabela em si.
	$arraytabelabase; // tabela 1d, representa alguns elementos da tabelas separados.
	$arraytabelacolunas; // tabela 1d, representa alguns elementos da tabelas separados.
	
	$arraytodasbase; //tabela 2d, representa a tabela de variaveis basicas, [(0)simbolo,(1)valor].
	
	$funcaoelementos;//o array final da funcao objetiva
	$regraselemento;//o array final 2d das regras
	
	/////////////////////////////////////////////////
	//Arrumando funcao objetiva:
	
	$funcoreplaced = str_replace(" ", "", $funcao);
	$funcaoexploded = explode("+", $funcoreplaced);	
	if(!empty($funcaoexploded)) 
	{
		for ($i = 0; $i < count($funcaoexploded); $i++) 
		{
			$value = explode("x", $funcaoexploded[$i])[0];
			$index = explode("x", $funcaoexploded[$i])[1] - 1;
			$funcaoelementos[$index] = $value;
		}
	}
	//print_r($funcaoelementos);
	
	/////////////////////////////////////////////////
	//Arrumando as regras:
	for ($i = 0; $i < count($sujeito); $i++) 
	{
		$regrasreplaced = str_replace(" ", "", $sujeito[$i]);
		$regrasexploded = explode("+", $regrasreplaced);
		
		for ($j = 0; $j < count($regrasexploded); $j++) 
		{
			$value = explode("x", $regrasexploded[$j])[0];
			$index = explode("x", $regrasexploded[$j])[1] - 1;
			$regraselemento[$i][$index] = $value;
		}
	//print_r($regraselemento);
	}
	//print_r($regraselemento);
	
	
	/////////////////////////////////////////////////
	//definindo as bases:
	$index = 0;
	for ($i = 0 ; $i < count($funcaoelementos) ; $i++) 
	{
		$arraytodasbase[$index][0] = "x".($i+1);
		$arraytodasbase[$index][1] = 0;
		$index++;
	}
	
	for ($i = 0 ; $i < count($regraselementovalor) ; $i++) 
	{
		$arraytodasbase[$index][0] = "f".($i+1);
		$arraytodasbase[$index][1] = $regraselementovalor[$i];
		$index++;
	}
	//print_r($arraytodasbase);
	
	/////////////////////////////////////////////////
	//MONTA TABELA AUXILIARES:
	
	//BASE:
	$finalx = 0;
	for ($x = 0 ; $x < count($regraselementovalor); $x++) 
	{
		//$arraytabelabase[$x] = $arraytodasbase[$x + (count($regraselementovalor))][0];//MUDEI AQUI PARA ARRUMAR BUG, tava -1
		$arraytabelabase[$x] = $arraytodasbase[$x + (count($arraytodasbase) - count($regraselementovalor))][0];//MUDEI AQUI PARA ARRUMAR BUG, tava -1
		$finalx = $x;
		//echo "DEBUG: ".$arraytabelabase[$x];
	}
		$arraytabelabase[$finalx + 1] = "z";
	//COLUNAS:
	$finalx = 0;
	for ($x = 0 ; $x < count($arraytodasbase) ; $x++) 
	{
		$arraytabelacolunas[$x] = $arraytodasbase[$x][0];
		$finalx = $x;
	}
	$arraytabelacolunas[$finalx + 1] = "b";
	
	//print_r($arraytabelabase);
	//echo "<br/>";
	//print_r($arraytabelacolunas);
	
	/////////////////////////////////////////////////
	//MONTA TABELA:
	
	$primeirox = -1;
	$primeiroy = -1;
	$primeirob = -1;
	$primeirofunc = -1;
	for ($x = 0 ; $x < count($arraytabelabase) ; $x++) 
	{
		for ($y = 0 ; $y < count($arraytabelacolunas) ; $y++) 
		{
			//DEFININDO LINHA Z
			if($arraytabelabase[$x] == "z")
			{
				//definindo F
				if(strpos($arraytabelacolunas[$y],'f') !== false)//ve se 'f' tem dentro
				{
					$arraytabela[$x][$y] = 0;
				}
				
				//definindo X
				if(strpos($arraytabelacolunas[$y],'x') !== false)//ve se 'x' tem dentro
				{
					if($primeirofunc == -1)
						$primeirofunc = $y;
					$arraytabela[$x][$y] = $funcaoelementos[$y - $primeirofunc] * -1;
				}
				//definindo B
				if($arraytabelacolunas[$y] == "b")
					$arraytabela[$x][$y] = 0;
			}
			else//DEFININDO OUTRAS LINHAS
			{
				//definindo F
				if($y <= count($arraytodasbase))
				{
					if($arraytabelabase[$x] == $arraytabelacolunas[$y]) // -1 pra tirar o Z 
						$arraytabela[$x][$y] = 1;
					else
						$arraytabela[$x][$y] = 0;
				}
				
				//definindo X
				if(strpos($arraytabelacolunas[$y],'x') !== false)//ve se x tem dentro
				{
					if($primeirox == -1)
						$primeirox = $x;
					if($primeiroy == -1)
						$primeiroy = $y;
					
					if(!isset($regraselemento[$x - $primeirox][$y - $primeiroy]))// ARRUMA O BUG (CODIGO: 0001)
						$arraytabela[$x][$y] = 0;
					else					
						$arraytabela[$x][$y] = $regraselemento[$x - $primeirox][$y - $primeiroy];
				}
				
				//definindo B
				if($arraytabelacolunas[$y] == "b")
				{
					if($primeirob == -1)
						$primeirob = $x;
					//$arraytabela[$x][$y] = $arraytodasbase[$x - $primeirob + count($regraselementovalor)][1];//BUG TIREI O -1 PARA ARRUMAR
					$arraytabela[$x][$y] = $arraytodasbase[$x - $primeirob + count($arraytodasbase) - count($regraselementovalor)][1];//BUG TIREI O -1 PARA ARRUMAR
					//$x + (count($arraytodasbase) - count($regraselementovalor)
				}
			}
			//echo $arraytabelabase[$x]."+".$arraytabelacolunas[$y]."=".$arraytabela[$x][$y];
			//echo "<br/>";
		}
	}
	
	/////////////////////////////////////////////////
	//PRINTA TABELA:
	if(!$somenteresultado)
	{
		echo "<br/>";
		echo "<h1 class=\"text-center\">Tabela Inicial</h1>";
	}
	
	if(!$somenteresultado)
		echo "<div class=\"container\">";
		PrintaTabela($arraytabelabase, $arraytabelacolunas, $arraytabela);
		echo "</div>";	
	/////////////////////////////////////////////////
	//PROCESSO:
	
	$tentativas = 0;
	do
	{
		$YLETRA;
		$XLETRA;
		if(!$somenteresultado)
		{
			echo "<br/>";
			echo "<h1 class=\"text-center\"> Iteração: ".($tentativas + 1)."</h1>";
		}
		/////////////////////////////////////////////////
		//MENOR VALOR DA TABELA:
		$menorindicey = -1;//coluna do menor valor
		$menorvalor = 99999999;//menor valor encontrado
		for ($x = 0 ; $x < count($arraytabelabase) ; $x++) 
		{
			for ($y = 0 ; $y < count($arraytabelacolunas) - 1; $y++)//-1 pois tirei o ultimo elemento 'b'
			{
				if($menorvalor >= $arraytabela[$x][$y])
				{
					$menorvalor = $arraytabela[$x][$y];
					//$menorindicex = $x;
					$menorindicey = $y;
				}
			}
		}
		if(!$somenteresultado)
			echo "<h3 class=\"text-center\"> Menor valor encontrado: ".$menorvalor. "</h3>";
		
		/////////////////////////////////////////////////
		//MENOR VALOR DA TABELA:
		$arraymenorvalorentrarbase = array();
		for ($x = 0 ; $x < count($arraytabelabase) - 1; $x++) //-1 pois o 'Z' nao pode entrar.
		{
			for ($y = 0 ; $y < count($arraytabelacolunas) - 1; $y++)//-1 pois tirei o ultimo elemento 'b'
			{
				if($y == $menorindicey)
				{
					if($arraytabela[$x][$y] == 0)
					{
						$arraymenorvalorentrarbase[$x][0] = null;
					}
					else
					{
						$arraymenorvalorentrarbase[$x][0] = ($arraytabela[$x][count($arraytabelacolunas) - 1] / $arraytabela[$x][$y]);
						$arraymenorvalorentrarbase[$x][1] = $arraytabelabase[$x];//qual letra que o represente;
					}
				}
			}
		}
		if(!$somenteresultado)
		{
			echo "<h3 class=\"text-center\">Efetuando divisão: </h3> <br/>";
			echo "<div class=\"container\">";
			PrintaTabelaMenorValor($arraymenorvalorentrarbase);
			echo "<br/>";
			echo "</div>";
		}
		
		/////////////////////////////////////////////////
		//MENOR VALOR DA TABELA:
		$menorvalorentrarbaseX = -1;		
		$menorvalorentrarbase = 99999999;
		for ($x = 0 ; $x < count($arraymenorvalorentrarbase) ; $x++) 
		{
			if($arraymenorvalorentrarbase[$x][0] !== null)
			{
				if($arraymenorvalorentrarbase[$x][0] <= $menorvalorentrarbase)
				{
					$menorvalorentrarbase = $arraymenorvalorentrarbase[$x][0];
					$menorvalorentrarbaseX = $x;
					$XLETRA = $arraymenorvalorentrarbase[$x][1];
				}
			}			
		}
		//echo "DEBUG: XLETRA: ".$XLETRA." Valor: ".$menorvalorentrarbase."<br/>";
		
		$YLETRA = $arraytabelacolunas[$menorindicey];
		
		//echo "DEBUG: YLETRA: ".$YLETRA;
		
		if(!$somenteresultado)
		{
			echo "<h3 class=\"text-center\">Menor valor encontrado apos a divisão: ".$menorvalorentrarbase."</h3>";
			echo "<h3 class=\"text-center\">Entra: ".$YLETRA. " Sai: ". $XLETRA."</h3>";
		}
		
		/////////////////////////////////////////////////
		//TIRANDO VALOR NOVO E COLOCANDO OUTRO NA COLUNA E BASE:
		for($x = 0; $x < count($arraytabelabase); $x++)
		{
			if ($arraytabelabase[$x] == $XLETRA)
			   $arraytabelabase[$x] = $YLETRA;
		}

		/////////////////////////////////////////////////
		//CALCULANDO PIVO:
		$pivox = $menorvalorentrarbaseX;
		$pivoy = $menorindicey;
		$pivo = $arraytabela[$pivox][$pivoy];
		
		if(!$somenteresultado)
		{
			echo "<h3 class=\"text-center\">Pivo: ".$pivo."</h3>";
			echo "<br>";
		}
		
		/////////////////////////////////////////////////
		//DIVIDE A LINHA TODA PELO PIVO:
		
		for ($y = 0 ; $y < count($arraytabelacolunas); $y++)
		{
			$arraytabela[$pivox][$y] = $arraytabela[$pivox][$y] / $pivo;
		}
		
		/////////////////////////////////////////////////
		//PRINTA TABELA:
	
		if(!$somenteresultado)
		{
			echo "<h1 class=\"text-center\">Tabela Após dividir pelo pivo:</h1>";
			echo "<div class=\"container\">";
			PrintaTabela($arraytabelabase, $arraytabelacolunas, $arraytabela);
			echo "</div>";
		}
		
		/////////////////////////////////////////////////
		//TROCANDO AS OUTRAS LINHAS:
		if(!$somenteresultado)
			echo "<h1 class=\"text-center\">Tabela Após processo de divisao por linha:</h1>";
		//echo "DEBUG: pivox+1: ".($pivox + 1);
		for($x = 0; $x <= count($arraytabelabase) - 1; $x++)
		{
			$valorespecial = $arraytabela[$x][$pivoy] * -1;
			//echo "DEBUG: ".$valorespecial." != 0 || ".$x." != ".$pivox;
			if($valorespecial != 0 && $x != $pivox)
			{
				if(!$somenteresultado)
				{
					echo "<h3 class=\"text-center\">Processo Linha: ". ($x + 1)."</h3>";
					echo "<br/>";
				}
				if(!$somenteresultado)
					echo "<h3 class=\"text-center\">Valor Especial: ". $valorespecial."</h3>";
				for($y = 0; $y < count($arraytabelacolunas); $y++)
				{
					if(!$somenteresultado)
						echo "<h3 class=\"text-center\">".$arraytabela[$pivox][$y]." * ".$valorespecial." + ".$arraytabela[$x][$y]." = ";
					$arraytabela[$x][$y] = (($arraytabela[$pivox][$y]) * $valorespecial) + $arraytabela[$x][$y];
					if(!$somenteresultado)
						echo "".$arraytabela[$x][$y]."</h3>";
				}
				if(!$somenteresultado)
					echo "<br/>";			
			}
		}
		
		/////////////////////////////////////////////////
		//PRINTA TABELA:
		if(!$somenteresultado)
		{
			echo "<h2 class=\"text-center\">Tabela final da iteração: </h2>";
			echo "<div class=\"container\">";
			PrintaTabela($arraytabelabase, $arraytabelacolunas, $arraytabela);
			echo "</div>";
		}
		
		$tentativas++;
	}
	while(CondicaoParada($arraytabela, $arraytabelacolunas, $arraytabelabase) == false ||  $qtdemaxima < $tentativas);
	
	PrintaFinais($arraytabelabase, $arraytabelacolunas, $arraytabela);
	
	echo "<br/>";
	echo "<h1 class=\"text-center\"> Tabela Final: </h1>";
	echo "<div class=\"container\">";
	PrintaTabela($arraytabelabase, $arraytabelacolunas, $arraytabela);
	echo "</div>";
	/////////////////////////////////////////////////
	//FUNCOES:
	function PrintaFinais($arraytabelabase, $arraytabelacolunas, $arraytabela)
	{
		echo "<br/>";
		echo "<h2 class=\"text-center\"> Variaveis Básicas: </h2>";
		for($x = 0; $x < count($arraytabelabase); $x++)
		{
			echo "<h3 class=\"text-center\">".$arraytabelabase[$x]." = ".$arraytabela[$x][count($arraytabelacolunas)- 1]."</h3>";
		}
		echo "<br/>";
		echo "<h2 class=\"text-center\"> Variaveis Não Básicas: </h2>";
		$arraysubtract = array_diff($arraytabelacolunas, $arraytabelabase);
		foreach ($arraysubtract as &$value) 
		{
			if($value == "b")
				continue;
			echo "<h3 class=\"text-center\">".$value." = 0"."</h3>";
		}
	}
	
	function CondicaoParada($arraytabela, $arraytabelacolunas, $arraytabelabase)
	{
		$retorno = true;
		for($y = 0; $y < count($arraytabelacolunas); $y++)
		{
			if($arraytabela[count($arraytabelabase) - 1][$y] < 0)
				$retorno = false;
		}
		return $retorno;
	}
	function PrintaTabelaMenorValor($arraymenorvalorentrarbase)
	{
		echo "<table class=\"table table-bordered\">";
		echo "<tbody>";
		echo "<tr class=\"btn-success text-center\">";
		echo "<td>";
		echo "<br/>";
		echo "Regras:  ";
		echo "<br/>";
		for ($x = 0 ; $x < count($arraymenorvalorentrarbase) ; $x++) 
		{
			echo ($x+1)."* - ";
			if($arraymenorvalorentrarbase[$x][0] === null)
			{
				echo "Não efetua divisão";
			}
			else
				echo $arraymenorvalorentrarbase[$x][1]." - ".$arraymenorvalorentrarbase[$x][0];
			echo "<br/>";
		}
		echo "<br/>";
		echo "</td>";
		echo "</tr>";
		echo "</tbody>";	
		echo "</table>";	
	}
	
	function PrintaInicio($funcao, $sujeito, $regraselementovalor, $qtdemaxima)
	{
		echo "<div class=\"container text-center\", style=\"font-size:20px; color: green;\">";
		echo "<div class=\"row\">";
		echo "MAX Z:  ";
		echo "<br/>";
		echo $funcao;
		echo "<br/>";
		echo "<br/>";
		echo "Restrições:  ";
		echo "<br/>";
		for ($x = 0 ; $x < count($sujeito) ; $x++) 
		{
			echo $sujeito[$x];
			echo " <= ";			
			echo $regraselementovalor[$x];
			echo "<br/>";
		}
		echo "<br/>";
		echo "Numero de iterações: ".$qtdemaxima;
		echo "<br/>";	
			echo "</td>";
		echo "</tr>";
		echo "</tbody>";	
		echo "</table>";
		echo "<br/>";	
		echo "<br/>";
		echo "</div>";
		echo "</div>";	
	}
	
	function PrintaTabela($arraytabelabase, $arraytabelacolunas, $arraytabela)
	{
		echo "<table class=\"table table-bordered\">";
		//cabecalho
		echo "<thead>";
		echo "<tr class=\"btn-success text-center\">";
		echo "<th class=\"text-center\">Base</th>";
		for ($x = 0 ; $x < count($arraytabelacolunas) ; $x++) 
		{
			echo "<th class=\"text-center\">";
			echo $arraytabelacolunas[$x];
			echo "</th>";
		}		
		echo "</tr>";
		echo"</thead>";
		//itens
		echo "<tbody>";
		for ($x = 0 ; $x < count($arraytabelabase); $x++) 
		{
			echo "<tr class=\"btn-success text-center\">";
			echo "<td>";
			echo $arraytabelabase[$x];
			echo "</td>";
			for ($y = 0 ; $y < count($arraytabelacolunas); $y++) 
			{
				echo "<td>";
				echo $arraytabela[$x][$y];
				echo "</td>";
			}	
			echo "</tr>";
		}		
		echo "</tbody>";		
		echo "</table>";
	}
	?>
</body>
</html>	
