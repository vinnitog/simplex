<html ng-app>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<title>Simplex</title>
</head>
<body>

<div class="container" id="general">
	<div ng-controller="principal" class="form">
		<form action="simplex.php" method="POST" target="_blank">		
			<h1 class="text-center">Simplex</h1>

			<label>Função Objetivo</label><br><br>
				<label>Maximizar: Z =</label>
				<input class="form-control" name="funcao" type="text" id="funcaoObjetivo" tabindex="1" size="70"><br><br>
			<hr style="box-shadow:0px 1px 2px green;">
			<label>Restrições</label><br><br>
			<input class="btn btn-success" type="button" id="btnAdicionar" tabindex="-1" value="Adicionar" style="width: 100px; height: 30px;" ng-click="add()"><br><br>						
			<div ng-repeat="item in items" class="sujeito">
				Restrição {{$index + 1}}:
				<input class="form-control" name="sujeito[]" type="text" id="regras" tabindex="2" size="20" > <= <input class="form-control" name="sujeito2[]" type="text" id="regras" tabindex="2" size="5">
				<input class="btn btn-danger" type="button" id="btnRemover" value="Remover" style="width: 100px; height: 30px;" ng-click="remover($index)">
				<br>

			</div><br>
			<input class="btn btn-primary" type="button" id="btnLimpar" tabindex="-1" value="Limpar Tudo" style="width: 100px; height: 30px;" ng-click="limpar()">				
			
			<br><br>
			<hr style="box-shadow:0px 1px 2px green;">
			<label>Numero de Iterações: </label>
			<input class="form-control" type="text" name="qtdemaxima" id="qtdeMaximaIteracoes" tabindex="3" >
			<!--<input type="checkbox" name="somenteresultado" id="ckbImprimirResultado" tabindex="4">
			<p>Imprimir somente o resultado</p>-->
			<input class="btn btn-success" type="submit" tabindex="-1" value="Calcular" >
									
		</form>
	</div>
</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.13/angular.min.js"></script>
    <script type="text/javascript">
	//script ANGULARJS
      var principal = function($scope){
		$scope.items = [];//cria array
        
        $scope.add = function (index) {
			$scope.items.push({ //insere valor no array
            indexvalue: index
			});
        };
		
		$scope.limpar = function () {
			$scope.items = [];//limpa array
			$scope.add(-1);//adiciona novo valor no array
        };
		
		$scope.remover = function(index){
			$scope.items.splice(index, 1);//remove do array
			if($scope.items.length == 0)
			{
				$scope.add(-1);//adiciona valor no array 
			}
		}
		
		$scope.add(-1);//adiciona valor no array na inicialização da tela
      }
    </script>
</html>
