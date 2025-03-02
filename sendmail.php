<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Hent og rens inputdata
    $name    = strip_tags(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $emne    = strip_tags(trim($_POST["emne"]));
    $message = trim($_POST["message"]);

    // Tjek at alle felter er udfyldte korrekt
    if (empty($name) || empty($message) || empty($emne) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: kontakt.html?success=0");
        exit;
    }

    // Opdateret modtager-e-mail
    $recipient = "sofie@tonagel.dk";
    $subject   = "Ny besked fra kontaktformularen - $name";

    // Opbyg e-mailens indhold
    $email_content  = "Navn: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Besked:\n$message\n";

    // Afsender (From) skal være en e-mail på dit domæne
    $email_headers  = "From: account@karolineprimdahl.dk\r\n";
    $email_headers .= "Reply-To: $email\r\n";

    // Forsøg at sende e-mailen
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        header("Location: kontakt.html?success=1");
        exit;
    } else {
        header("Location: kontakt.html?success=0");
        exit;
    }
} else {
    header("Location: kontakt.html");
    exit;
}
?>
