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
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);
    try {
 $user = $provider->getResourceOwner($token);
 $userDetails = $user->toArray();
 $email = $userDetails['email'];
 $stmt = $dbh->prepare('SELECT * FROM utilizatori WHERE email = ?');
$stmt->execute([$email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($existingUser) {
  $_SESSION['nume_de_utilizator'] = $existingUser['nume_de_utilizator'];
     header('Location: contul_meu.php');
           exit;
        } else {
            exit('Utilizatorul nu se poate găsi în baza de date. Încercați din nou cu alte date.');
        }
    } catch (Exception $e) {
        exit('Eroare la obținerea detaliilor utilizatorului: '.$e->getMessage());
}
}
$authUrl = $provider->getAuthorizationUrl([
    'prompt' => 'select_account'
]);
$_SESSION['oauth2state'] = $provider->getState();
header('Location: '.$authUrl);
exit;
?>
