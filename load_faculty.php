<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$collection = $client->uiurp->faculties;

$faculties = $collection->find([], [
    'projection' => [
        '_id' => 1,
        'name' => 1,
        'bio' => 1,
        'profile_image' => 1
    ]
])->toArray();

// Convert ObjectId to string
foreach ($faculties as &$faculty) {
    $faculty['_id'] = (string) $faculty['_id'];
}

echo json_encode($faculties);
?>
