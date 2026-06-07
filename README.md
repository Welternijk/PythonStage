# Survey Project (HTML, CSS, JS, PHP)

Dit is een eenvoudige webapplicatie waar gebruikers een vragenlijst kunnen invullen en admins de resultaten kunnen inzien.

## Functionaliteiten
- **Homepagina**: Een formulier met drie vragen (Naam, Telefoon, Afdeling).
- **Beveiliging**: 
    - E-mailvalidatie op de inlogpagina (moet een `@` bevatten).
    - Gebruik van PDO Prepared Statements om SQL-injectie te voorkomen.
    - Sessie-beheer voor het admin-gedeelte.
- **Database**: Opslag van alle antwoorden in een MySQL database.
- **Admin Paneel**: Een beveiligde omgeving om de resultaten in een tabel te bekijken.

## Vereisten
- Een lokale webserver zoals **XAMPP**, **WAMP**, of **MAMP**.
- PHP 7.4 of hoger.
- MySQL/MariaDB.

## Installatie Instructies

1. **Database opzetten**:
    - Start de Apache en MySQL modules in je control panel (bijv. XAMPP).
    - Open `phpMyAdmin` (meestal op `http://localhost/phpmyadmin`).
    - Maak een nieuwe database aan met de naam `survey_db`.
    - Klik op de database, ga naar het tabblad **SQL** en plak daar de inhoud van het bestand `schema.sql`. Voer dit uit.
    - Dit maakt de tabellen aan en voegt één standaard admin toe:
        - **E-mail**: `admin@bedrijf.nl`
        - **Wachtwoord**: `admin123`

2. **Project bestanden plaatsen**:
    - Kopieer alle bestanden naar de `htdocs` map van je server installatie.
    - Bijvoorbeeld: `C:/xampp/htdocs/survey-project/`.

3. **Configuratie controleren**:
    - Open `db.php` en controleer of de inloggegevens voor je database kloppen (standaard is `root` zonder wachtwoord voor XAMPP).

4. **De applicatie draaien**:
    - Open je browser en ga naar `http://localhost/survey-project/index.php`.

## Gebruik
1. Vul op de homepagina de vragen in en klik op "Verstuur".
2. Klik rechtsboven op "Admin Login".
3. Log in met `admin@bedrijf.nl` en `admin123`.
4. Je ziet nu een overzicht van alle ingevulde formulieren.

## Troubleshooting
- **Database Error**: Controleer of de database naam in `db.php` exact overeenkomt met de naam in phpMyAdmin.
- **PHP niet gevonden**: Zorg dat je de bestanden via `http://localhost/` opent en niet door simpelweg dubbel te klikken op de .php bestanden in de verkenner.
