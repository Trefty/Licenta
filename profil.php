<?php
session_start();
if (!isset($_SESSION['nume de utilizator'])) {
    echo 'Trebuie să vă autentificați mai întâi!';
    exit;
}
$dbh = new PDO('mysql:host=localhost;dbname=users', 'root', 'Galardo45');
$stmt = $dbh->prepare('SELECT * FROM userss WHERE nume_de_utilizator= ?');
$stmt->execute([$_SESSION['nume_de_utilizator']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pagina de profil</title>
</head>
<body>
    <h1>Bine ați venit, <?php echo htmlspecialchars($user['nume_de_utilizator']); ?>!</h1>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <p>Joc preferat: <?php echo htmlspecialchars($user['joc']); ?></p>
</body>
</html>
