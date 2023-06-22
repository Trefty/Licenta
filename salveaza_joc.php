<!DOCTYPE html>
<html>
<head>
    <title>Pagina de profil</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet"> 
    <style>
        body {
           background: linear-gradient(120deg, #0000FF, #8A2BE2);
        margin: 0;
    padding: 0;
           font-family: 'Press Start 2P', cursive; 
         display: flex;
        justify-content: center;
          align-items: center;
        min-height: 100vh;
        }
        .message-container {
         max-width: 400px;
        padding: 20px;
           border: 4px solid #43D926;
            border-radius: 20px;
           background: rgba(0, 0, 0, 0.7); 
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
          color: #43D926; 
        text-align: center;
        animation: float 4s ease-in-out infinite; 
        }
     h1 {
        font-size: 32px;
           margin-bottom: 20px;
       color: #43D926;
     }
        .success-message {
          color: #43D926; 
      font-size: 25px;
    margin-top: 20px;
          font-family: 'Press Start 2P', cursive; 
        }
        .error-message {
            color: #FF0000; 
           font-size: 25px;
         margin-top: 20px;
         font-family: 'Press Start 2P', cursive; 
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
        .ggamezone-button {
            position: absolute;
            top: 10px;
            left: 10px;
            color: #43D926;
            font-size: 20px;
            text-decoration: none;
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $joc = $_POST['joc'];
           $dbh = new PDO('mysql:host=localhost;dbname=users', 'root', 'Galardo45');
           $stmt = $dbh->prepare('SELECT id FROM utilizatori WHERE nume_de_utilizator = ?');
          $stmt->execute([$_SESSION['nume_de_utilizator']]);
         $user = $stmt->fetch(PDO::FETCH_ASSOC);
      $userId = $user['id'];
            $stmt_insert = $dbh->prepare('UPDATE utilizatori SET joc_preferat = ? WHERE id = ?');
          $stmt_insert->execute([$joc, $userId]);

            echo '<div class="message-container">
              <h1>Jocul preferat a fost salvat cu succes!</h1>
                  </div>';
        } else {
            echo '<div class="message-container">
              <h1>Accesul la acest fișier nu este permis!</h1>
           </div>';
        }
    } else {
        echo '<div class="message-container">
         <h1>Trebuie să vă autentificați pentru a accesa această pagină!</h1>
          <a href="login.php" class="auth-button">Autentificare</a>
        <a href="register.php" class="auth-button">Înregistrare</a>
              </div>';
    }
    ?>
    <a href="GGamezone.html" class="ggamezone-button">GGamezone</a>
</body>
</html>
