<?php
$dbh = new PDO('mysql:host=localhost;dbname=users', 'root', 'Galardo45');

$errorMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume_de_utilizator = $_POST['nume_de_utilizator'];
    $firstname = $_POST['prenume'];
    $lastname = $_POST['nume_de_familie'];
    $email = $_POST['email'];
    $password = $_POST['parola'];

    $stmt = $dbh->prepare('SELECT * FROM utilizatori WHERE nume_de_utilizator = ?');
    $stmt->execute([$nume_de_utilizator]);
    $userExists = $stmt->fetch(PDO::FETCH_ASSOC);
    function validatePassword($password)
    {
        if (strlen($password) >= 4 && strlen($password) <= 20) {
            return true;
        }
        return false;
    }
    function validateName($name)
    {
        if (strlen($name) >= 3 && strlen($name) <= 20) {
            return true;
        }
        return false;
    }    
    function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
    
    if ($userExists) {
        $errorMsg = 'Numele de utilizator există deja';
    } elseif (!validatePassword($password)) {
        $errorMsg = 'Parola trebuie să aibă între 4 și 20 de caractere';
    } elseif (!validateName($firstname)) {
        $errorMsg = 'Prenumele trebuie să aibă între 3 și 20 de caractere';
    } elseif (!validateName($lastname)) {
        $errorMsg = 'Numele de familie trebuie să aibă între 3 și 20 de caractere';
    } elseif (!validateEmail($email)) {
        $errorMsg = 'Adresa de email este invalidă';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $dbh->prepare('INSERT INTO utilizatori (nume_de_utilizator, prenume, nume_de_familie, email, parola) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$nume_de_utilizator, $firstname, $lastname, $email, $hashedPassword]);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formular de înregistrare</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(120deg, #8a2be2, #0000ff);
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            padding: 30px;
            width: 400px;
            max-width: 90%;
        }
        .button {
            background-color: #8a2be2;
            padding: 9px 2px;
            border: none;
            border-radius: 10px;
            color: #ffffff;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            font-size: 16px;
            transition: background-color 0.3s;
            cursor: pointer;
            width: 100%;
            margin: 10px 0;
        }

        .button:hover {
            background-color: #0000ff;
        }

        .button img {
            vertical-align: middle;
            margin-right: 10px;
        }

        h2 {
            margin: 0 0 15px;
            text-align: center;
        }

        label {
            display: block;
            margin: 0 0 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin: 0 0 15px;
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        input[type="submit"] {
            background-color: #8a2be2;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0000ff;
        }

        .error-message {
            background-color: #ff0000;
            color: #ffffff;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .success-message {
            background-color: #008000;
            color: #ffffff;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .error-input {
            border: 1px solid #ff0000;
        }
    </style>
</head>
<body>
    
    <a href="GGamezone.html" style="position:absolute; top:10px; left:10px; color: white; text-decoration: none; font-size: 20px;">
        GGamezone
    </a>
    <div class="container">
        <h2>Formular de înregistrare</h2>
        <?php if ($errorMsg !== '') : ?>
            <p class="error-message"><?php echo $errorMsg; ?></p>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p class="success-message">Utilizatorul a fost înregistrat cu succes!</p>
        <?php endif; ?>
        <form method="POST" action="inregistrare.php">
            <label for="nume_de_utilizator">Nume de utilizator:</label>
            <input type="text" name="nume_de_utilizator" id="nume_de_utilizator" required>
            
            <label for="prenume">Prenume:</label>
            <input type="text" name="prenume" id="prenume" required>
            
            <label for="nume_de_familie">Nume de familie:</label>
            <input type="text" name="nume_de_familie" id="nume_de_familie" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required <?php if($errorMsg !== '') echo 'class="error-input"'; ?>>
            
            <label for="parola">Parolă:</label>
            <input type="password" name="parola" id="parola" required>
            
            <input type="submit" value="Înregistrare" class="button">
    <a href="autentificare.php" class="button">
        Autentificare
    </a>
            
        </form>
    </div>
</body>
</html>
