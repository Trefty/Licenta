<!DOCTYPE html>
<html lang="en">
<head>
<script>
    function confirmNavigation() {
       return confirm('Vreți să vă întoarceți la pagina principală?');
    }
  </script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: radial-gradient(circle at center, #4c7de4, #9000ad);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      padding: 50px;
    }
    .logo {
      font-size: 36px;
      color: #ccc;
      text-decoration: none;
      position: absolute;
      top: 10px;
      left: 10px;
    }
    h2, h3 {
      font-size: 30px;
    }
    ul {
      font-size: 22px;
      list-style-type: none;
      padding: 0;
    }
    .compatibility-pass {
      color: #0f0;
      text-shadow:  0 0 10px #0f0;
    }
    .compatibility-fail {
      color: #ee1010;
      text-shadow: 0 0 10px #f00;
    }
    .compatibility-result {
      text-align: center;
      max-width: 800px;
      margin: auto;
    }
  </style>
</head>

<body>
  <a href="GGamezone.html" class="logo" onclick="return confirmNavigation();">
    GGamezone
  </a>

  <div class="container">
    <h2>Joc ales:<?php echo isset($gameName) ? ' ' . $gameName : ''; ?></h2>

    <?php
    require_once 'bazadedate_jocurilevideo.php';
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        die("Pagina nu este disponibilă. Încearcă mai târziu.");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['joc_id']) && isset($_POST['placa_video']) && isset($_POST['procesor'])) {
     $selectedGameId = $_POST['joc_id'];
    $selectedVideoCardId = $_POST['placa_video'];
    $selectedProcessorId = $_POST['procesor'];
 $stmt_requirements = $conn->prepare("SELECT * FROM jocurilevideo WHERE id = ?");
     $stmt_requirements->bind_param("i", $selectedGameId);
   $stmt_requirements->execute();
  $result_requirements = $stmt_requirements->get_result();

     if ($result_requirements && $result_requirements->num_rows > 0) {
   $row_requirements = $result_requirements->fetch_assoc();    

 $selectedGame = $conn->query("SELECT nume_joc FROM jocurilevideo WHERE id = $selectedGameId")->fetch_assoc();
     $gameName = $selectedGame['nume_joc'];
$selectedVideoCard = $conn->query("SELECT * FROM placi_video WHERE id = $selectedVideoCardId")->fetch_assoc();
     $selectedProcessor = $conn->query("SELECT * FROM procesoare WHERE id = $selectedProcessorId")->fetch_assoc();
  $minReqVideoCard = $conn->query("SELECT * FROM placi_video WHERE id = {$row_requirements['cerinte_minime_placa_video_id']}")->fetch_assoc();
   $minReqProcessor = $conn->query("SELECT * FROM procesoare WHERE id = {$row_requirements['cerinte_minime_procesor_id']}")->fetch_assoc();
      $recReqVideoCard = $conn->query("SELECT * FROM placi_video WHERE id = {$row_requirements['cerinte_recomandate_placa_video_id']}")->fetch_assoc();
     $recReqProcessor = $conn->query("SELECT * FROM procesoare WHERE id = {$row_requirements['cerinte_recomandate_procesor_id']}")->fetch_assoc();

            $isMinimumRequirementsPassedV = ($selectedVideoCard['viteza_ceas'] >= $minReqVideoCard['viteza_ceas'] && 
            $selectedVideoCard['memorie'] >= $minReqVideoCard['memorie']);

        $isMinimumRequirementsPassedP = ($selectedProcessor['viteza_ceas'] >= $minReqProcessor['viteza_ceas'] &&
             $selectedProcessor['numar_nuclee'] >= $minReqProcessor['numar_nuclee'] && 
      $selectedProcessor['tehnologie_procesor'] <= $minReqProcessor['tehnologie_procesor']);

            $isRecommendedRequirementsPassedV = ($selectedVideoCard['viteza_ceas'] >= $recReqVideoCard['viteza_ceas'] &&
       $selectedVideoCard['memorie'] >= $recReqVideoCard['memorie']);

     $isRecommendedRequirementsPassedP = ($selectedProcessor['viteza_ceas'] >= $recReqProcessor['viteza_ceas'] && 
     $selectedProcessor['numar_nuclee'] >= $recReqProcessor['numar_nuclee'] &&
      $selectedProcessor['tehnologie_procesor'] <= $recReqProcessor['tehnologie_procesor']);

   $selectedRAM = isset($_POST['memorie_ram']) ? preg_replace('/[^0-9]/', '', $_POST['memorie_ram']) : '';
    $selectedRAM = intval($selectedRAM);
    $minReqRAM = isset($row_requirements['cerinte_minime_memorie_ram']) ? intval(preg_replace('/[^0-9]/', '', $row_requirements['cerinte_minime_memorie_ram'])) : '';
    $recReqRAM = isset($row_requirements['cerinte_recomandate_memorie_ram']) ? intval(preg_replace('/[^0-9]/', '', $row_requirements['cerinte_recomandate_memorie_ram'])) : '';
    $isMinimumRAMPassed = ($selectedRAM >= $minReqRAM);
  $isRecommendedRAMPassed = ($selectedRAM >= $recReqRAM);

            echo '<div class="compatibility-result">';
  echo '<h3>' . $gameName . '</h3>';
  echo '<h3>Cerințe minime:</h3>';
     echo '<ul>';
  echo '<li>Placă video: ' . ($isMinimumRequirementsPassedV ? '<span class="compatibility-pass">Rulează</span>' : '<span class="compatibility-fail">&#10060;</span>') . ' - ' . $selectedVideoCard['nume_placa_video'] . '</li>';
echo '<li>Procesor: ' . ($isMinimumRequirementsPassedP ? '<span class="compatibility-pass">Rulează</span>' : '<span class="compatibility-fail">&#10060;</span>') . ' - ' . $selectedProcessor['nume_procesor'] . '</li>';
echo '<li>Memorie RAM: ' . ($isMinimumRAMPassed ? '<span class="compatibility-pass">Rulează</span>' : '<span class="compatibility-fail">&#10060;</span>') . '</li>';
  echo '</ul>';
     echo '<h3>Cerințe recomandate:</h3>';
   echo '<ul>';
echo '<li>Placă video: ' . ($isRecommendedRequirementsPassedV ? '<span class="compatibility-pass">Rulează</span>' : '<span class="compatibility-fail">&#10060;</span>') . ' - ' . $selectedVideoCard['nume_placa_video'] . '</li>';
  echo '<li>Procesor: ' . ($isRecommendedRequirementsPassedP ? '<span class="compatibility-pass">Rulează</span>' : '<span class="compatibility-fail">&#10060;</span>') . ' - ' . $selectedProcessor['nume_procesor'] . '</li>';
  echo '<li>Memorie RAM: ' . ($isRecommendedRAMPassed ? '<span class="compatibility-pass">Rulează</span>' : '<span class="compatibility-fail">&#10060;</span>') . '</li>';
  echo '</ul>';
    echo '</div>';
        }
    }
    ?>
  </div>
</body>
</html>
