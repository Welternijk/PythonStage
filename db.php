<?php
// --- DATABASE INSTELLINGEN ---
$host = 'localhost';    // De naam van de server waarop de database draait (meestal localhost bij XAMPP)
$db   = 'survey_db';    // De naam van de specifieke database die we in phpMyAdmin hebben aangemaakt
$user = 'root';         // De standaard gebruikersnaam van de database beheerder in XAMPP
$pass = '';             // Het wachtwoord van de database (standaard leeg bij XAMPP)
$charset = 'utf8mb4';   // De karakterset die we gebruiken, zodat ook speciale tekens en emoji's goed worden opgeslagen

// --- DSN (Data Source Name) ---
// Dit is de 'verbindingsstring' die PHP vertelt welk type database we gebruiken en waar deze staat
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// --- PDO OPTIES ---
// Hier stellen we in hoe de database-verbinding zich moet gedragen
$options = [
    // Zorgt ervoor dat PHP een duidelijke foutmelding (Exception) geeft als er iets misgaat met een SQL-query
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    
    // Zorgt ervoor dat resultaten uit de database standaard als 'associative arrays' worden teruggegeven (makkelijk leesbaar)
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
    
    // Schakelt emulatie uit, zodat we gebruikmaken van echte 'prepared statements' (essentieel voor Cybersecurity/SQL-injectie preventie)
    PDO::ATTR_EMULATE_PREPARES   => false,                  
];

// --- DE VERBINDING MAKEN ---
try {
    // Hier proberen we de daadwerkelijke verbinding met de database te openen via het PDO-object
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Als de verbinding mislukt (bijv. verkeerd wachtwoord of database staat uit), vangt dit blok de fout op
    // 'die' stopt het script onmiddellijk en toont de foutmelding op het scherm
    die("Database verbinding mislukt: " . $e->getMessage());
}
?>