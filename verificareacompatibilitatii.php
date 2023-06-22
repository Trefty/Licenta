<!DOCTYPE html>
<html>
<head>
    <style>
 @font-face {
      font-family: 'DaCherry';
   src: url('DaCherry.ttf');
    }
  body {
    background: linear-gradient(to right, #0000ff, #800080, #800080);
    color: white;
     font-family: 'DaCherry', 'Comic Sans MS', 'Chalkboard SE', 'Marker Felt', sans-serif;
    animation: backgroundAnimation 20s infinite linear;
    }
  @keyframes backgroundAnimation {
      0% {
    background-position: 0% 50%;
     }
    50% {
              background-position: 100% 50%;
     }
      100% {
   background-position: 0% 50%;
      }
    }
    .compatibility-form {
      max-width: 600px;
      margin: auto;
    background: rgba(0, 0, 0, 0);
      padding: 20px;
    border-radius: 4px;
    animation: formAnimation 1s ease-in-out;
    }
   @keyframes formAnimation {
     0% {
       opacity: 0;
      transform: scale(0.5);
    }
     100% {
     opacity: 1;
     transform: scale(1);
      }
    }
  .form-group {
    margin-bottom: 20px;
   display: flex;
   justify-content: space-between;
        align-items: center;
   animation: formGroupAnimation 1s ease-in-out;
    }
    @keyframes formGroupAnimation {
    0% {
    opacity: 0;
     transform: translateX(-50%);
      }
    100% {
   opacity: 1;
     transform: translateX(0);
      }
    }
  .form-group label {
     margin-bottom: 5px;
    font-size: 18px;
   flex: 1;
    }
    .form-group p {
   font-weight: bold;
     font-size: 16px;   
  color: #f8f8ff;
    text-shadow: 2px 2px 4px #000000;
  flex: 1;
   text-align: right;
    }
    h3, h4 {
   text-align: center;
   font-size: 24px;
     text-shadow: 2px 2px 4px #000000;
      animation: headingAnimation 1s ease-in-out;
    }
    @keyframes headingAnimation {
      0% {
       opacity: 0;
       transform: translateY(-20px);
      }
      100% {
       opacity: 1;
       transform: translateY(0);
      }
    }
    select, button {
      width: 100%;
      padding: 10px;
     border-radius: 4px;
    border: none;
    font-size: 16px;
      animation: inputAnimation 1s ease-in-out;
    }
    @keyframes inputAnimation {
      0% {
        opacity: 0;
      transform: translateY(-20px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
    button {
  background: #8b0000;
    color: white;
     cursor: pointer;
   transition: background 0.3s;
    font-size: 20px;
     text-shadow: 2px 2px 4px #000000;
   animation: buttonAnimation 1s ease-in-out;
   }
    @keyframes buttonAnimation {
      0% {
      opacity: 0;
        transform: scale(0.5);
      }
      100% {
        opacity: 1;
        transform: scale(1);
      }
    }
    button:hover {
  background:#32CD32;
    }
  </style>
</head>
<body>
<?php
    session_start();
require_once 'bazadedate_jocurilevideo.php';
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Pagina nu este disponibilă. Încearcă mai târziu.");
}
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['joc_id'])) {
      $selectedGameId = $_POST['joc_id']; 
      $sql_game = "SELECT * FROM jocurilevideo WHERE id = ?";
     $stmt_game = $conn->prepare($sql_game);
     $stmt_game->bind_param("i", $selectedGameId);
     $stmt_game->execute();
      $result_game = $stmt_game->get_result();
      if ($result_game && $result_game->num_rows > 0) {
        $row_game = $result_game->fetch_assoc();
        $gameName = $row_game['nume_joc'];
        echo '<h3>Testează Compatibilitatea pentru jocul '.$gameName.'</h3>';
      echo '<form class="compatibility-form" method="POST" action="testare.php">';
        echo '<input type="hidden" name="joc_id" value="'.$selectedGameId.'">';
       echo '<h4>Cerințe minime:</h4>';
        echo '<div class="form-group">';
        echo '<label>Procesor:</label>';
       echo '<p>'.$row_game['cerinte_minime_procesor'].'</p>';
      echo '</div>';
       echo '<div class="form-group">';
       echo '<label>Placă video:</label>';
      echo '<p>'.$row_game['cerinte_minime_placa_video'].'</p>';
        echo '</div>';
       echo '<div class="form-group">';
       echo '<label>Memorie RAM minima:</label>';
      echo '<p>'.$row_game['cerinte_minime_memorie_ram'].'</p>';
        echo '</div>';
        echo '<div class="form-group">';
      echo '<label>OS Minim:</label>';
        echo '<p>'.$row_game['os_minim'].'</p>';
        echo '</div>';
       echo '<div class="form-group">';
       echo '<label>Spatiu Necesar:</label>';
       echo '<p>'.$row_game['spatiu_necesar'].'</p>';
        echo '</div>';
        echo '<h4>Cerințe recomandate:</h4>';
        echo '<div class="form-group">';
      echo '<label>Procesor:</label>';
      echo '<p>'.$row_game['cerinte_recomandate_procesor'].'</p>';
        echo '</div>';
       echo '<div class="form-group">';
      echo '<label>Placă video:</label>';
      echo '<p>'.$row_game['cerinte_recomandate_placa_video'].'</p>';
        echo '</div>';
        echo '<div class="form-group">';
     echo '<label>Memorie RAM recomandata:</label>';
        echo '<p>'.$row_game['cerinte_recomandate_memorie_ram'].'</p>';
        echo '</div>';    
      echo '<div class="form-group">';
       echo '<label>OS Recomandat:</label>';
      echo '<p>'.$row_game['os_recomandat'].'</p>';
     echo '</div>';
      echo '<div class="form-group">';
        echo '<label>Spatiu Necesar:</label>';
       echo '<p>'.$row_game['spatiu_necesar'].'</p>';
       echo '</div>';
      echo '<div class="form-group">';
       echo '<label>Memorie RAM:</label>';
      echo '<select id="memorie_ram" name="memorie_ram">';
        echo '<option value="1">1 </option>';
       echo '<option value="2">2 </option>';
      echo '<option value="4">4 </option>';
        echo '<option value="8">8 </option>';
      echo '<option value="16">16 </option>';
       echo '<option value="32">32 </option>';
       echo '</select>';
      echo '</div>';
        $sql_proc = "SELECT * FROM procesoare";
        $result_proc = $conn->query($sql_proc);
       echo '<div class="form-group">';
        echo '<label for="procesor">Alege procesorul:</label>';
     echo '<select id="procesor" name="procesor">';
       while ($row_proc = $result_proc->fetch_assoc()) {
          echo '<option value="'.$row_proc['id'].'">'.$row_proc['nume_procesor'].'</option>';
        }
      echo '</select>';
        echo '</div>';
      $sql_gpu = "SELECT * FROM placi_video";
     $result_gpu = $conn->query($sql_gpu);
       echo '<div class="form-group">';
      echo '<label for="placa_video">Alege placa video:</label>';
    echo '<select id="placa_video" name="placa_video">';
      while ($row_gpu = $result_gpu->fetch_assoc()) {
          echo '<option value="'.$row_gpu['id'].'">'.$row_gpu['nume_placa_video'].'</option>';
    }
       echo '</select>';
        echo '</div>';
      echo '<button type="submit">Verifică jocul</button>';
        echo '</form>';
      }
    }
  ?>
</body>
</html>
