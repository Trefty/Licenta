<?php
$loginError = false;
session_start();
require_once 'bazadedate_users.php';
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Pagina nu este disponibilă. Încearcă mai târziu.");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username = $_POST['nume_de_utilizator'];
 $password = $_POST['password'];
 $query = 'SELECT * FROM utilizatori WHERE nume_de_utilizator = ?';
 $stmt = $conn->prepare($query);
 $stmt->bind_param('s', $username);
 $stmt->execute();
 $user = $stmt->get_result()->fetch_assoc();
 
if ($user && password_verify($password, $user['parola'])) {
    $_SESSION['nume_de_utilizator'] = $username;
  header('Location: contul_meu.php');
 exit;
    } else {
        $loginError = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Autentificare</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: indigo;
        color: white;
        font-family: 'Arial', sans-serif;
            display: flex;
      flex-direction: column;
        justify-content: center;
           align-items: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            font-family: 'Pacifico', cursive;
            font-size: 2em;
           text-align: center;
            color: white;
            margin-bottom: 20px;
        }
        form {
            background: rgba(75, 0, 130, 0.8);
          padding: 20px;
            border-radius: 8px;
            width: 300px;
        }
        .error-message {
        color: red;
           font-size: 1.5em;
            text-align: center;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
          padding: 10px;
            margin: 10px 0;
          border-radius: 4px;
            border: 1px solid #eee;
        }
        input[type="submit"] {
            background-color: indigo;
           color: white;
        border: none;
           cursor: pointer;
         padding: 10px 20px;
         border-radius: 4px;
            margin-top: 10px;
        }
    input[type="submit"]:hover {
            background-color: #6A0DAD;
        }
        .login-google {
            display: flex;
         align-items: center;
     justify-content: center;
            margin-top: 10px;
        }
        .login-google a {
           display: flex;
         align-items: center;
      justify-content: center;
          color: white;
           text-decoration: none;
        background-color: #DB4437;
          padding: 10px 20px;
          border-radius: 4px;
          transition: background-color 0.3s ease;
     }
        .login-google a:hover {
          background-color: #C62121;
        }
        .login-google img {
            width: 20px;
         margin-right: 5px;
        }
       .login-google span {
       font-size: 16px;
         font-weight: bold;
        }
        .floating-icons {
        display: flex;
        justify-content: space-between;
        align-items: center;
    width: 200px;
         margin-top: 20px;
     }
      .floating-icons img {
         width: 50px;
          margin: 0 10px;
         transform: rotate(45deg);
           animation: spin 4s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(45deg); }
            100% { transform: rotate(-315deg); }
        }
    </style>
</head>
<body>
    <?php if ($loginError) { ?>
        <div class="error-message">Eroare la autentificare!</div>
    <?php } else { ?>
        <h1>Bine ai venit!</h1>
    <?php } ?>
    <form method="POST" action="autentificare.php">
        <input type="text" name="nume_de_utilizator" placeholder="Nume de utilizator">
        <input type="password" name="password" placeholder="Parola">
        <input type="submit" value="Autentificare">
    </form>
    <div class="login-google">
        <a href="login-google.php">
     <img src="imagini/google_logo.png" alt="Logo Google">
         <span>Autentificare cu Google</span>
     </a>
    </div>
    <div class="floating-icons">
<img src="imagini/mc.png" alt="Minecraft Icon">
<img src="imagini/mc1.png" alt="Potiune Icon">
<img src="imagini/mc2.png" alt="CSGO Icon">

    </div>
</body>
</html>
