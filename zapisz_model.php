<?php
// Ustawienie nagłówka dla komunikacji z JS
header('Content-Type: application/json');

$jsonFile = 'baza_plastmer_full.json';

// Pobranie danych z JS
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data) {
    // Wczytanie obecnej bazy
    $jsonString = file_get_contents($jsonFile);
    $baza = json_decode($jsonString, true);

    // Aktualizacja lub dodanie modelu
    $modelNum = $data['model'];
    $baza[$modelNum] = [
        "klient" => $data['klient'],
        "projekt" => $data['projekt'],
        "warstwy" => $data['warstwy']
    ];

    // Zapis do pliku
    if (file_put_contents($jsonFile, json_encode($baza, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        echo json_encode(["status" => "success"]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Nie można zapisać pliku"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Brak danych"]);
}
?>