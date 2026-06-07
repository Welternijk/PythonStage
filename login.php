<?php
session_start(); // Start de sessie om inloggegevens te kunnen onthouden over verschillende pagina's
require_once 'db.php'; // Maakt verbinding met de database via het eerder gemaakte db.php bestand

$error = ''; // Variabele om eventuele foutmeldingen in op te slaan

// Controleer of de gebruiker op de "Inloggen" knop heeft gedrukt (POST methode)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']); // Haalt het emailadres op en verwijdert extra spaties
    $password = $_POST['password']; // Haalt het ingevoerde wachtwoord op

    // --- CYBERSECURITY: VALIDATIE ---
    // filter_var controleert of het ingevoerde adres een geldig e-mailformaat heeft (bevat een @ en een domein)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Voer een geldig e-mailadres in (moet een @ bevatten).";
    } else {
        // --- DATABASE CONTROLE ---
        // We gebruiken een 'prepared statement' om SQL-injectie te voorkomen (veiligheid!)
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]); // Zoekt de admin op basis van het e-mailadres
        $admin = $stmt->fetch(); // Haalt de gegevens van de admin op uit de database

        // Controleert of de admin bestaat en of het wachtwoord klopt
        if ($admin && $password === $admin['password']) {
            // LOGIN GESLAAGD: Sla gegevens op in de sessie
            $_SESSION['admin_logged_in'] = true; // Onthoudt dat de beheerder succesvol is ingelogd
            $_SESSION['admin_email'] = $admin['email']; // Slaat het emailadres op voor later gebruik
            header("Location: admin.php"); // Stuurt de admin door naar het beveiligde dashboard
            exit; // Stopt het script hier
        } else {
            // LOGIN MISLUKT
            $error = "Onjuiste inloggegevens.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Koppelt de CSS voor een mooie lay-out -->
</head>
<body>

<nav>
    <!-- Link om makkelijk terug te gaan naar de homepagina (vragenlijst) -->
    <a href="index.php" style="text-decoration:none; color:var(--primary-color);">← Terug naar Home</a>
</nav>

<div class="container" style="max-width: 400px;">
    <h2>Admin Login</h2>
    
    <!-- Als er een fout is opgetreden, tonen we deze hier in een rood blokje -->
    <?php if($error): ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- Het inlogformulier -->
    <form action="login.php" method="POST" id="loginForm">
        <div class="form-group">
            <label for="email">E-mailadres</label>
            <!-- type="email" zorgt voor automatische basis-check in de browser -->
            <input type="email" id="email" name="email" required placeholder="admin@bedrijf.nl">
        </div>

        <div class="form-group">
            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" required placeholder="Wachtwoord">
        </div>

        <button type="submit" style="width: 100%;">Inloggen</button>
    </form>
</div>

<script>
    // --- EXTRA CYBERSECURITY CHECK (CLIENT-SIDE) ---
    // Deze Javascript code controleert nóg een keer of er een @ in het veld staat voordat het formulier verzonden wordt
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        if(!email.includes('@')) {
            alert("Ongeldig emailadres. Een @ is verplicht."); // Waarschuwing aan de gebruiker
            e.preventDefault(); // Stopt het verzenden naar de server
        }
    });
</script>

</body>
</html>