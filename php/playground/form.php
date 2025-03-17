<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>form prova</title>
</head>
<body>
    <form action = "form_action.php" method="post">
        <div>
            <label for = "email"> email </label>
            <input type="email" id="email" name="email" placeholder="esempio@mail.it" required>
        </div>
        <div>
            <label for = "password"> password </label>
            <input type="password" id="password" name="password" placeholder="password" required>
        </div>
        <div>
            <label for = "eta"> età </label>
            <input type="number" id="eta" name="eta" placeholder="11" min="8" max="99" required>
        </div>

        <!-- RADIOBUTTONS -->
        <label for = "sesso"> sesso </label>
        <div>
            <input type="radio" id="maschio" name="sesso" value="maschio" required>
            <label for="maschio">Maschio</label>
            <input type="radio" id="femmina" name="sesso" value="femmina" required>
            <label for="femmina">Femmina</label>
        </div>

        <!-- CHECKBOXES -->
        <label for = "colori"> Colori preferiti</label>
        <div>
            <input type = "checkbox" id = "rosso" name="colori[]" value = "rosso" >
            <label> Rosso </label>
            <input type = "checkbox" id = "verde" name="colori[]" value = "verde" >
            <label> Verde </label>
            <input type = "checkbox" id = "giallo" name="colori[]" value = "giallo" >
            <label> Giallo </label>
            <input type = "checkbox" id = "blu" name="colori[]" value = "blu" >
            <label> Blu </label>
        </div>
        <div>
            <label for = "colore"> colore sfondo</label>
            <select id = "colore" name = "bg">
                <option value = "black"> nero </option>
                <option value = "red"> rosso </option>
                <option value = "green"> verde</option>
            </select>
        </div>
        <button type="submit">submit</button>
    </form>
</body>
</html>
