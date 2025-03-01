<?php
include 'service/config.php';

$stmt = $conn->prepare("SELECT * FROM siswa_ajax");
$stmt->execute();
$result = $stmt->get_result();
$data = [];


while ($row = $result->fetch_assoc()){
    $data[] = $row;
}


echo json_encode($data);


?>