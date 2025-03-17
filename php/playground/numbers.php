<?php
$ripetizioni=5;
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



<form action="action_page_number.php" method="post">
    <?php for($i = 0; $i < $ripetizioni; $i++) { ?>
        <label for="<?=$i?>">Valutazione del servizio </label><br>
        <input type="number" name="numero[]" id="<?=$i?>" min="1" max="5"><br>
        <hr>
    <?php } ?>
    <input type="hidden" name="rip" value=<?=$ripetizioni?>>
    <input type="submit" value="invia">
</form>
</body>
</html>


</body>
</html>
