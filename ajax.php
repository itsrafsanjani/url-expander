<?php

$data = json_decode(file_get_contents('php://input'), true);

header('Content-Type: application/json; charset=utf-8');

if ($data['url']) {
    $url = $data['url'];
    if (!empty($url)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $a = curl_exec($ch);
        $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        echo json_encode([
            'success' => true,
            'message' => 'Url expanded successfully!',
            'url' => $url
        ]);
        return;
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Input field(s) are empty!'
        ]);
        return;
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Input is not provided'
    ]);
    return;
}
