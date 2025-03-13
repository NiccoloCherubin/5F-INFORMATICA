<?php
$alimentari = require_once 'alimentari.php';
//echo $alimentari['frutta'];
//primo esempio di copia
$copiaAlimentari = array_merge([],$alimentari);
//var_dump($copiaAlimentari);

//secondo esempio di copia
$duplicatoDiCopiaAlimentari=[];
foreach ($alimentari as $alimento=>$item){
    $duplicatoDiCopiaAlimentari[$alimento]=$item;
}
//var_dump($duplicatoDiCopiaAlimentari);

//terzo esempio di copia
$secondoDuplicatoDiCopiaAlimentari=[];
foreach ($alimentari as $alimento=>$item){
    $secondoDuplicatoDiCopiaAlimentari+=[$alimento=>$item];
}
var_dump($secondoDuplicatoDiCopiaAlimentari); die();
$tipoAlimentari= array_keys($alimentari);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

<!--visualizzazione dei valori con foreach annidato -->
<?php foreach($copiaAlimentari as $tipoAlimento=>$alimenti) { ?>
    <h2 class="tipoAlimento"><?=$tipoAlimento?></h2>
        <?php foreach($alimenti as $sceltaAlimento){ ?>
            <p class="alimentoScelto"><?=$sceltaAlimento?></p>
        <?php } ?>
    <?php } ?>
<hr>

<!--visualizzazione di uno specifico valore con indice -->
<p><?=$alimentari['frutta'][0]?></p>
<hr>

<!--visualizzazione di un tipo di alimento con tutte le scelte -->
<?php foreach($alimentari['frutta'] as $frutta){ ?>
    <p><?=$frutta?></p>
<?php }?>
<hr>

<form action="action_page.php" method="post">
    <?php for($i = 0; $i < count($alimentari); $i++) { ?>
        <p><?=$tipoAlimentari[$i]?></p>
        <label for="<?=$i?>Val">Valutazione del servizio </label><br>
        <input type="number" name="<?=$i?>Val" id="<?=$i?>Val" min="1" max="5"><br>
        <label for="<?=$i?>Pag">Carta di credito</label><br>
        <input type="checkbox" id="<?=$i?>Pag" name="<?=$i?>Pag" value="Pagamento"><br>
        <label for="<?=$i?>Cons">consegna a domicilio </label><br>
        <input type="checkbox" id="<?=$i?>Cons" name="<?=$i?>Cons" value="Consegna"><br>
        <hr>
    <?php } ?>
    <input type="hidden" name="count" value=<?=count($alimentari)?>>
    <input type="submit" value="invia">
</form>
</body>
</html>


</body>
</html>
