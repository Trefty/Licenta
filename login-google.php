<?php
require 'vendor/autoload.php';

session_start();
$dbh = new PDO('mysql:host=localhost;dbname=users', 'root', 'Galardo45');
$provider = new League\OAuth2\Client\Provider\Google([
    'clientId'     => '753871759931-9m7toaqtgmvi3gequnk1p2fqjli5531s.apps.googleusercontent.com',
    'clientSecret' => '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',
    'redirectUri'  => 'http://localhost/login-google-callback.php',
]);
if (isset($_GET['code'])) {
    try {
        $user = $provider->getResourceOwner($token);
        $userDetails = $user->toArray();
    
        $firstName = $userDetails['name']['givenName'];
        $lastName = $userDetails['name']['familyName'];
        $email = $userDetails['email'];
    
        $stmt = $dbh->prepare('SELECT * FROM utilizatori WHERE email = ?');
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($existingUser) {
            $_SESSION['nume_de_utilizator'] = $existingUser['nume_de_utilizator'];
            header('Location: contul_meu.php');
            exit;
        } else {
            $stmt = $dbh->prepare('INSERT INTO utilizatori (Prenume, nume_de_familie, nume_de_utilizator, email, joc_preferat) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$firstName, $lastName, $email, '']);
            $_SESSION['nume_de_utilizator'] = $email;
            header('Location: contul_meu.php');
            exit;
        }
    } catch (Exception $e) {
        exit('Eroare la obținerea detaliilor utilizatorului: '.$e->getMessage());
    }
    
}
$authUrl = $provider->getAuthorizationUrl();
$_SESSION['oauth2state'] = $provider->getState();
header('Location: '.$authUrl);
exit;
?>