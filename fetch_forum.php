<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

$mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;
$collection = $db->forum;

$forums = $collection->find()->toArray();

header('Content-Type: application/json');
if (empty($forums)) {
    echo json_encode(['message' => 'No forums found']);
} else {
    echo json_encode($forums);
}
?>