<?php
// Start de sessie zodat we feedbackberichten (succes/fout) kunnen tonen aan de gebruiker
session_start(); 
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bedrijfs Vragenlijst</title>
    <!-- Koppelt het externe CSS-bestand voor de vormgeving van de pagina -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <!-- De navigatiebalk met de naam van de applicatie -->
    <div class="logo"><strong>SurveyApp</strong></div>
    <!-- Knop die de bezoeker naar de inlogpagina voor beheerders stuurt -->
    <a href="login.php" class="btn-admin">Admin Login</a>
</nav>

<div class="container">
    <h1>Vragenlijst</h1>
    
    <!-- CHECK: Is er een succesbericht ingesteld in de sessie? (Bijv. na het verzenden) -->
    <?php if(isset($_SESSION['success'])): ?>
        <div class="message success">
            <?php 
                echo $_SESSION['success']; // Toon het bericht
                unset($_SESSION['success']); // Verwijder het bericht direct zodat het niet opnieuw verschijnt bij vernieuwen
            ?>
        </div>
    <?php endif; ?>

    <!-- CHECK: Is er een foutmelding ingesteld? -->
    <?php if(isset($_SESSION['error'])): ?>
        <div class="message error">
            <?php 
                echo $_SESSION['error']; // Toon de foutmelding
                unset($_SESSION['error']); // Verwijder de melding uit de sessie
            ?>
        </div>
    <?php endif; ?>

    <!-- Het formulier dat de data naar submit.php stuurt via de POST methode -->
    <form action="submit.php" method="POST" id="surveyForm">
        
        <!-- VRAAG 1: Naam invoerveld -->
        <div class="form-group">
            <label for="fullname">Vraag 1: Wat is je naam?</label>
            <input type="text" id="fullname" name="fullname" required placeholder="Bijv. Jan Janssen">
        </div>

        <!-- VRAAG 2: Telefoonnummer invoerveld -->
        <div class="form-group">
            <label for="phone">Vraag 2: Wat is je telefoon nummer?</label>
            <input type="tel" id="phone" name="phone" required placeholder="0612345678">
        </div>

        <!-- VRAAG 3: Keuzemenu voor de afdeling -->
        <div class="form-group">
            <label for="department">Vraag 3: Op welke afdeling werk je?</label>
            <select id="department" name="department" required>
                <option value="">Kies een afdeling...</option>
                <option value="IT">IT</option>
                <option value="HR">HR</option>
                <option value="Marketing">Marketing</option>
                <option value="Sales">Sales</option>
                <option value="Klantenservice">Klantenservice</option>
            </select>
        </div>

        <!-- Verzendknop om de gegevens naar de database te sturen -->
        <button type="submit">Verstuur Antwoorden</button>
    </form>
</div>

<script>
    // CLIENT-SIDE VALIDATIE: Een extra controle voordat de data naar de server gaat
    document.getElementById('surveyForm').addEventListener('submit', function(e) {
        const name = document.getElementById('fullname').value; // Pak de waarde van het naamveld
        const phone = document.getElementById('phone').value;   // Pak de waarde van het telefoonveld

        // Check of de naam wel lang genoeg is (minimaal 2 tekens)
        if(name.length < 2) {
            alert("Vul a.u.b. een geldige naam in."); // Toon waarschuwing
            e.preventDefault(); // Stop het verzenden van het formulier
        }
    });
</script>

</body>
</html>