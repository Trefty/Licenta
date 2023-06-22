<!DOCTYPE html>
<html>
<head>
 <title>Pagina de profil</title>
 <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet"> 
 <style>
        body {
        background: indigo;
        margin: 0;
        padding: 0;
       font-family: 'Press Start 2P', cursive; 
         display: flex;
        justify-content: center;
         align-items: center;
         min-height: 100vh;
        }
        .profile-container {
        max-width: 600px;
        padding: 40px;
           border-radius: 20px;
        background-color: rgba(0, 0, 0, 0.7); 
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
     color: #43D926; 
          text-align: center;
         animation: float 4s ease-in-out infinite; 
        }
        h1 {
         font-size: 36px;
         margin-bottom: 30px;
         color: #43D926;
        }
        p {
         font-size: 20px;
         color: #43D926;
         margin-bottom: 10px;
        }
        .login-message {
            color: #43D926; 
            font-size: 25px;
            margin-top: 20px;
          display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Press Start 2P', cursive; 
        }
        .login-message .icon {
            width: 50px;
            margin-top: 10px;
        }
        .auth-button {
            display: inline-block;
            margin: 10px;
            color: #43D926; 
            text-decoration: none;
            border: 2px solid #43D926; 
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 20px;
            transition: background 0.3s ease;
            text-shadow: 2px 2px #000; 
        }
        .auth-button:hover {
            background: #43D926;
            color: #000;
        }
        .dropdown {
            width: 100%;
            margin-bottom: 25px;
            margin-top: 10px; 
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            color: #43D926;
            font-size: 16px;
            padding: 5px;
            box-sizing: border-box;
            border: none;
        }
        .dropdown option {
            background-color: #000000;
            color: #43D926;
            font-size: 16px;
        }
        .save-section {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 10px;
            border-radius: 10px;
        }
        .save-section input[type="submit"] {
            background: #43D926;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body>
    <?php
    session_start();
    if (isset($_SESSION['nume_de_utilizator'])) {
        $dbh = new PDO('mysql:host=localhost;dbname=users', 'root', 'Galardo45');
        $stmt = $dbh->prepare('SELECT * FROM utilizatori WHERE nume_de_utilizator = ?');
        $stmt->execute([$_SESSION['nume_de_utilizator']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
$stmtEmail = $dbh->prepare('SELECT * FROM utilizatori WHERE email = ?');
    $stmtEmail->execute([$user['email']]);
    $existingUserEmail = $stmtEmail->fetch(PDO::FETCH_ASSOC);
        }
    ?>
<div class="profile-container">
<h1>Bine ați venit, <?php echo htmlspecialchars($user['nume_de_utilizator']); ?>!</h1>
<p>Nume de familie: <?php echo htmlspecialchars($user['nume_de_familie']); ?></p>
 <p>Prenume: <?php echo htmlspecialchars($user['Prenume']); ?></p>
<p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
<p>Joc preferat: <?php echo htmlspecialchars($user['joc_preferat']); ?></p> 
<div class="save-section">
<form method="POST" action="salveaza_joc.php">
<label for="joc">Alegeți un nou joc preferat:</label>
<br>
<select name="joc" id="joc" class="dropdown">
    
<?php
    require_once 'bazadedate_jocurilevideo.php';
 $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 if ($conn->connect_error) {
  error_log("Connection failed: " . $conn->connect_error);
     die("Pagina nu este disponibilă. Încearcă mai târziu.");
    }

    $result = $conn->query('SELECT nume_joc FROM jocurilevideo');
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $value = $row['nume_joc'];
            echo "<option value='$value'>$value</option>";
            
        }
    }
    $conn->close();
    
?>

</select>
<br>
<input type="submit" value="Salvează jocul preferat">
</form>
</div>
</div>

    <?php
    } else {
    ?>
       <div class="login-message">
      <p>Vă rugăm să vă autentificați</p>
     <img class="icon" src="imagini/exclamation_icon.png" alt="Exclamation Icon">
     <a href="autentificare.php" class="auth-button">Autentificare</a>
     <a href="inregistrare.php" class="auth-button">Înregistrare</a>
        </div>
    <?php
    }
  ?>
</body>
</html>
