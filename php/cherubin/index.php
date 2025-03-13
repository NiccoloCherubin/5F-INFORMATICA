<?php
echo "Niccolò Cherubin 5F fila B"
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form</title>
</head>
<body>
    <h1> Inserire dati azienda </h1>
    <form action="action.php" method="post">
        <!-- Text input -->
        <div>
            <label for="nome"> Nome azienda</label>
            <div>
                <input type="text" id="nome" name="nome" placeholder="nome" required>
            </div>
            <label for="citta">Città</label>
            <div>
                <input type="text" id="citta" name="citta" placeholder="Venezia" required>
            </div>
            <label for="indirizzo">Indirizzo</label>
            <div>
                <input type="text" id="indirizzo" name="indirizzo" placeholder="Via verdi 84" required>
            </div>
            <label for="telefono">Numero di telefono</label>
            <div>
                <input type="text" id="telefono" name="telefono" placeholder="+39 000 000 0000" required>
            </div>
        </div>
        <!-- Checkboxes -->
        <div>
            <label for="estere">Aziende estere con cui si collabora (max 4) </label>
            <div>
                <input type="checkbox" id="estere" name="estere[]" value="Francia"> Francia
                <input type="checkbox" id="estere" name="estere[]" value="Spagna"> Spagna
                <input type="checkbox" id="estere" name="estere[]" value="Germania"> Germania
                <input type="checkbox" id="estere" name="estere[]" value="Inghilterra"> Inghilterra
                <input type="checkbox" id="estere" name="estere[]" value="Stati Uniti"> Stati Uniti
            </div>
        </div>
        <!-- Numbers -->
        <div>
            <label for="NFrancia">Numero aziende in Francia </label>
            <div>
                <input type="number" id="NFrancia" name="NFrancia" min="0">
            </div>
            <label for="NSpagna">Numero aziende in Spagna </label>
            <div>
                <input type="number" id="NSpagna" name="NSpagna" min="0">
            </div>
            <label for="NGermania">Numero aziende in Germania </label>
            <div>
                <input type="number" id="NGermania" name="NGermania" min="0">
            </div>
            <label for="NInghilterra">Numero aziende in Inghilterra </label>
            <div>
                <input type="number" id="NInghilterra" name="NInghilterra" min="0">
            </div>
            <label for="NUsa">Numero aziende in Stati Uniti </label>
            <div>
                <input type="number" id="NUsa" name="NUsa" min="0">
            </div>
        </div>
        <button type="submit"> invia </button>

    </form>
</body>
</html>
