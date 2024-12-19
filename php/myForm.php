<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo di Registrazione</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .input-group div {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="radio"], input[type="checkbox"] {
            width: auto;
            margin-right: 5px;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Modulo di Registrazione</h1>
    <form id="contactForm" method="post" action="display.php">
        <div class="input-group">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="input-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="input-group">
            <label for="comment">Commento:</label>
            <textarea id="comment" name="comment" rows="5" cols="50"></textarea>
        </div>

        <!-- Radio Buttons (Single choice) -->
        <div class="input-group">
            <label for="gender">Sesso:</label>
            <div>
                <input type="radio" id="maschio" name="gender" value="maschio" required>
                <label for="maschio">Maschio</label>

                <input type="radio" id="femmina" name="gender" value="femmina" required>
                <label for="femmina">Femmina</label>

                <input type="radio" id="altro" name="gender" value="altro" required>
                <label for="altro">Altro</label>
            </div>
        </div>

        <!-- Checkboxes (Multiple choice) -->
        <div class="input-group">
            <label for="interests">Interessi:</label>
            <div>
                <input type="checkbox" id="sport" name="interests[]" value="sport">
                <label for="sport">Sport</label>

                <input type="checkbox" id="musica" name="interests[]" value="musica">
                <label for="musica">Musica</label>

                <input type="checkbox" id="viaggi" name="interests[]" value="viaggi">
                <label for="viaggi">Viaggi</label>

                <input type="checkbox" id="arte" name="interests[]" value="arte">
                <label for="arte">Arte</label>
            </div>
        </div>

        <!-- Dropdown (Select box) -->
        <div class="input-group">
            <label for="city">Città:</label>
            <select id="city" name="city" required>
                <option value="milano">Milano</option>
                <option value="roma">Roma</option>
                <option value="napoli">Napoli</option>
                <option value="torino">Torino</option>
                <option value="firenze">Firenze</option>
            </select>
        </div>

        <!-- Listbox (Multiple selection) -->
        <div class="input-group">
            <label for="languages">Lingue conosciute:</label>
            <select id="languages" name="languages[]" multiple required>
                <option value="italiano">Italiano</option>
                <option value="inglese">Inglese</option>
                <option value="francese">Francese</option>
                <option value="spagnolo">Spagnolo</option>
                <option value="tedesco">Tedesco</option>
            </select>
        </div>

        <button type="submit">Invia</button>
    </form>
</div>

</body>
</html>
