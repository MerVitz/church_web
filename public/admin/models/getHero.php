<?php
include_once __DIR__ . "/../models/heroModel.php";
header("Content-Type: application/json");

if (!isset($_GET['hero_id'])) {
    echo json_encode(["error" => "Missing hero_id"]);
    exit();
}

$heroData = getHeroById($conn, $_GET['hero_id']);
echo json_encode($heroData ?: ["error" => "Hero not found"]);
