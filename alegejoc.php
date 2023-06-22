<?php
header('Content-Type: application/json');
$conn = new mysqli('localhost', 'root', 'Galardo45', 'licenta');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT id, nume_joc FROM jocurilevideo ORDER BY id ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $jocuri = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($jocuri);
} else {
    echo json_encode([]);
}
$conn->close();
?>
