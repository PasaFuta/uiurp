<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

$mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;
$collection = $db->forum;

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['title']) && isset($data['content'])) {
    $post = [
        'title' => $data['title'],
        'content' => $data['content'],
        'upvotes' => 0,
        'downvotes' => 0,
        'views' => 0,
        'comments' => []
    ];
    $result = $collection->insertOne($post);
    echo json_encode(['success' => true, 'id' => $result->getInsertedId()]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
}
?>