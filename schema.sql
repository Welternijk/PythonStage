-- --- DATABASE AANMAKEN ---
-- Maakt een nieuwe database genaamd 'survey_db' aan, maar alleen als deze nog niet bestaat
CREATE DATABASE IF NOT EXISTS survey_db;

-- Vertelt MySQL dat alle volgende opdrachten binnen deze specifieke database uitgevoerd moeten worden
USE survey_db;

-- --- TABEL VOOR ANTWOORDEN ---
-- Hier slaan we alle ingevulde vragenlijsten van de gebruikers op
CREATE TABLE IF NOT EXISTS responses (
    id INT AUTO_INCREMENT PRIMARY KEY,       -- Uniek nummer voor elke inzending, telt automatisch op
    fullname VARCHAR(100) NOT NULL,          -- Kolom voor de volledige naam (max 100 tekens)
    phone VARCHAR(20) NOT NULL,               -- Kolom voor het telefoonnummer
    department VARCHAR(100) NOT NULL,         -- Kolom voor de geselecteerde afdeling
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Slaat automatisch de datum en tijd van inzenden op
);

-- --- TABEL VOOR ADMINS ---
-- Hier slaan we de inloggegevens voor de beheerders op
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,       -- Uniek nummer voor elke beheerder
    email VARCHAR(255) NOT NULL UNIQUE,      -- E-mailadres van de admin, 'UNIQUE' zorgt dat je niet twee keer hetzelfde mailadres kunt gebruiken
    password VARCHAR(255) NOT NULL           -- Het wachtwoord voor de admin
);

-- --- STANDAARD GEGEVENS ---
-- We voegen direct één beheerder toe zodat je meteen kunt inloggen om te testen
-- 'IGNORE' zorgt ervoor dat de code geen foutmelding geeft als de admin al bestaat
INSERT IGNORE INTO admins (email, password) 
VALUES ('admin@bedrijf.nl', 'admin123'); 