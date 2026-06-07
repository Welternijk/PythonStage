<?php
// Start de sessie zodat we resultaatmeldingen (zoals "Bedankt!") kunnen terugsturen naar index.php
session_start();
// Haalt de databaseverbinding op uit db.php
require_once 'db.php';

// Controleert of de pagina is aangeroepen via het formulier (POST-methode)
// Dit voorkomt dat mensen het script rechtstreeks openen in de browser
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // De trim() functie verwijdert onnodige spaties aan het begin en eind van de invoer
    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $department = trim($_POST['department']);

    // --- SERVER-SIDE VALIDATIE ---
    // Controleert of een van de velden leeg is gebleven
    if (empty($fullname) || empty($phone) || empty($department)) {
        // Als er iets mist, slaan we een foutmelding op in de sessie
        $_SESSION['error'] = "Alle velden zijn verplicht.";
        // Stuur de gebruiker direct terug naar het formulier
        header("Location: index.php");
        exit; // Stop de rest van het script
    }

    // --- DATA VEILIG OPSLAAN ---
    try {
        // CYBERSECURITY: We gebruiken 'prepared statements' met vraagtekens (?)
        // Dit zorgt ervoor dat hackers geen kwaadaardige SQL-codes kunnen injecteren
        $sql = "INSERT INTO responses (fullname, phone, department) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        // De echte gegevens worden pas hier veilig gekoppeld en verzonden naar de database
        $stmt->execute([$fullname, $phone, $department]);
        
        // Als het is gelukt, maken we een groen succesbericht aan
        $_SESSION['success'] = "Bedankt! Je antwoorden zijn succesvol opgeslagen.";
        
    } catch (Exception $e) {
        // Als er een technisch probleem is met de database, vangen we de fout op
        $_SESSION['error'] = "Er ging iets mis bij het opslaan: " . $e->getMessage();
    }

    // Na het verwerken sturen we de gebruiker altijd terug naar de homepagina
    header("Location: index.php");
    exit;

} else {
    // Als iemand de pagina probeert te bezoeken zonder het formulier te gebruiken, sturen we ze direct weg
    header("Location: index.php");
    exit;
}
?>