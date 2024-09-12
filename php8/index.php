<?php

// Variáveis
$nome = "Luan Kaio";
$sobrenome = "Silva Alves";
$idade = 20;
$numero = 10;
$mediaIdade = 30;

// Declaração das Variáveis
echo "Meu nome é ", $nome ," ", $sobrenome ," e eu tenho ", $idade ," anos ";

// Operadores Aritiméticos

// Adição
$total = $idade + $numero;
// Subtração
$total2 = $idade - $numero;
// Multiplicação
$total3 = $idade * $numero;
// Divisão
$total4 = $idade / $numero;

echo '<br> <br> Minha idade, mais 10, é igual ', $total;
echo '<br> Minha idade, menos 10, é igual a ', $total2;
echo '<br> Minha idade, multiplicado por 10, é igual a ', $total3;
echo '<br> Minha idade, dividido por 10, é igual a ', $total4;

// Tomada de Decisão

if($idade > $mediaIdade){
    echo '<br> Minha idade é maior do que <br> ', $mediaIdade;
}

else if($idade == 27){
    echo '<br> Minha idade é 27 anos <br>';
}{
    echo '<br> <br> Minha idade é menor do que ', $mediaIdade ,' e também não é igual a 27 anos <br>';
}

// Laços de Repetição (for)

for($cont = 0; $cont <= 5; $cont++){
    if($cont == 3){
        echo "<br> <br> O valor de cont é 3 <br> ";
    }
    echo '<br> O valor de "cont" é ', $cont;
}

?>
