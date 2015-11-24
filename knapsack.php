<!--0-1 Knapsack Problem Solve with memoization optimize and index returns
$peso = peso do item
$valor = valor do item
$i = index
$peso_disponivel = peso disponivel
$memorizar_itens = memorizar itens array
It works uncorrectly! For examle if $aw=4. Max value is true, but no "Array Indices" and its parameters are displayed
-->
<link rel="stylesheet" type="text/css" href="bootstrap.css">
<?php  
function Mochila($peso,$valor,$i,$peso_disponivel,&$memorizar_itens) {

    global $num_chamadas;
    $num_chamadas ++;
    //echo "Called with i=$i, peso_disponivel=$peso_disponivel<br>";

    // Return memo if we have one
    if (isset($memorizar_itens[$i][$peso_disponivel])) {
        return array( $memorizar_itens[$i][$peso_disponivel], $memorizar_itens['escolhido'][$i][$peso_disponivel] );
    } else {

        // At end of decision branch
        if ($i == 0) {
            if ($peso[$i] <= $peso_disponivel) { // Esse item irá caber?
                $memorizar_itens[$i][$peso_disponivel] = $valor[$i]; // Memoriza esse item
                $memorizar_itens['escolhido'][$i][$peso_disponivel] = array($i); // e Memoriza o item escolhido
                return array($valor[$i],array($i)); // Retorna o valor desse item e adiciona ele na lista de escolhidos

            } else {
                // Não irá caber
                $memorizar_itens[$i][$peso_disponivel] = 0; // Memoriza zero
                $memorizar_itens['escolhido'][$i][$peso_disponivel] = array(); // e Memoriza um array vazio...
                return array(0,array()); // Retorna nada
            }
        }   

        // Not at end of decision branch..
        // Get the result of the next branch (without this one)
        list ($without_i,$without_PI) = Mochila($peso, $valor, $i-1, $peso_disponivel,$memorizar_itens,$itens_escolhidos);

        if ($peso[$i] > $peso_disponivel) { // Does it return too many?

            $memorizar_itens[$i][$peso_disponivel] = $without_i; // Memo without including this one
            $memorizar_itens['escolhido'][$i][$peso_disponivel] = array(); // and a blank array entry...
            return array($without_i,array()); // and return it

        } else {

            // Get the result of the next branch (WITH this one picked, so available weight is reduced)
            list ($with_i,$with_PI) = Mochila($peso, $valor, ($i-1), ($peso_disponivel - $peso[$i]),$memorizar_itens,$itens_escolhidos);
            $with_i += $valor[$i];  // ..and add the value of this one..

            // Get the greater of WITH or WITHOUT
            if ($with_i > $without_i) {
                $res = $with_i;
                $escolhido = $with_PI;
                array_push($escolhido,$i);
            } else {
                $res = $without_i;
                $escolhido = $without_PI;
            }

            $memorizar_itens[$i][$peso_disponivel] = $res; // Store it in the memo
            $memorizar_itens['escolhido'][$i][$peso_disponivel] = $escolhido; // and store the picked item
            return array ($res,$escolhido); // and then return it
        }   
    }
}



$itens_existentes = array("caixa1","caixa2","caixa3","caixa4","caixa5");
$peso_itens = array(12,1,4,1,2);
$valor_itens = array(4,2,10,1,2);

## Inicializacão
$num_chamadas = 0; 
$memorizar_itens = array(); 
$itens_escolhidos = array();


## Resolver
list ($item_memorizado,$itens_escolhidos) = Mochila($peso_itens,$valor_itens, sizeof($valor_itens) -1, 15,$memorizar_itens,$itens_escolhidos);

## Resultado a ser mostrado
echo "<h2 class=\"text-center\">Knapsack - Programação Dinâmica</h2>";
echo "<div style=\"margin-left:100px\" class=\"container\">";
echo "<br><b>Itens:</b><br>".join(", ",$itens_existentes)."<br><br>";
echo "<b>Maior valor Encontrado:</b><br>$item_memorizado"." $"."<br><br>";
//echo "<b>Array Indices:</b><br>".join(",",$itens_escolhidos)."<br><br>";


echo "<b>Itens Escolhidos:</b><br>";
echo "<table class=\"table table-bordered\">";
echo "<tr><td>Item</td><td>Valor do Item</td><td>Peso do Item</td></tr>";
foreach($itens_escolhidos as $key) {
    $valor_total += $valor_itens[$key];
    $peso_total += $peso_itens[$key];
    echo "<tr><td>".$itens_existentes[$key]."</td><td>".$valor_itens[$key]." $"."</td><td>".$peso_itens[$key]." kg"."</td></tr>";
}
echo "<tr class=\"btn-success\"><td><b>Total</b></td><td>$valor_total"." $"."</td><td>$peso_total"." kg"."</td></tr>";
echo "</table><br>";
echo "</div>";
?>