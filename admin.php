<?php
session_start(); // Start de sessie om te kunnen controleren of de admin is ingelogd
require_once 'db.php'; // Haalt het bestand op dat de verbinding met de database regelt

// --- CYBERSECURITY: TOEGANGSCONTROLE ---
// Hier checken we of de sessie-variabele 'admin_logged_in' bestaat en op 'true' staat
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Als je niet bent ingelogd, word je direct teruggestuurd naar de inlogpagina
    header("Location: login.php");
    exit; // Stopt de uitvoering van de rest van het script
}

// --- DATA OPHALEN ---
// We bereiden een SQL-query voor om alle rijen uit de tabel 'responses' te halen
// 'ORDER BY submitted_at DESC' zorgt ervoor dat de nieuwste antwoorden bovenaan staan
$stmt = $pdo->query("SELECT * FROM responses ORDER BY submitted_at DESC");
$responses = $stmt->fetchAll(); // Slaat alle gevonden resultaten op in de variabele $responses
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Resultaten</title>
    <link rel="stylesheet" href="style.css"> <!-- Koppelt de CSS voor de opmaak -->
</head>
<body>

<nav>
    <div class="logo"><strong>Admin Panel</strong></div>
    <div>
        <!-- htmlspecialchars voorkomt dat hackers scripts kunnen injecteren via hun e-mailadres (XSS beveiliging) -->
        <span>Ingelogd als: <?php echo htmlspecialchars($_SESSION['admin_email']); ?></span>
        <a href="logout.php" class="btn-admin" style="margin-left: 10px;">Uitloggen</a>
    </div>
</nav>

<div class="container" style="max-width: 900px;">
    <h2>Ingezonden Vragenlijsten</h2>
    
    <?php if(count($responses) > 0): ?> <!-- Checkt of er überhaupt wel antwoorden in de database staan -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Telefoon</th>
                    <th>Afdeling</th>
                    <th>Datum</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($responses as $row): ?> <!-- Start een loop die door elk antwoord heen loopt -->
                    <tr>
                        <!-- Toont de data uit de database kolommen in de tabelcellen -->
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['department']); ?></td>
                        <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
                    </tr>
                <?php endforeach; ?> <!-- Einde van de loop -->
            </tbody>
        </table>
    <?php else: ?>
        <!-- Deze melding verschijnt als de tabel in de database nog leeg is -->
        <p>Er zijn nog geen inzendingen gevonden.</p>
    <?php endif; ?>
</div>

</body>
</html>