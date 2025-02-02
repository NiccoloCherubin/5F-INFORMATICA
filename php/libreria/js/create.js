// Aggiungi un evento al pulsante per il reindirizzamento
document.getElementById("submitBtn").addEventListener("click", function(event) {
    event.preventDefault(); // Previene l'invio del form

    // Reindirizza alla pagina read.php
    window.location.href = "read.php";
});
