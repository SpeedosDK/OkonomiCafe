<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $navn = htmlspecialchars($_POST["navn"]);
    $email = htmlspecialchars($_POST["email"]);
    $besked = htmlspecialchars($_POST["besked"]);

    // Send email (simpelt eksempel)
    $to = "kontakt@oekonomi-cafeen.dk";
    $subject = "Ny henvendelse fra $navn";
    $message = "Navn: $navn\nEmail: $email\n\nBesked:\n$besked";

    mail($to, $subject, $message);

    // Redirect til tak-side
    header("Location: /tak.php");
    exit;
}
