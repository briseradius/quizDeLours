<?php
require_once 'bdd.php'; // Inclure le fichier de connexion à la base de données

// Requête SQL pour récupérer les questions
$query = "SELECT question, bonne_reponse, mauvaise_reponse1, mauvaise_reponse2, mauvaise_reponse3, theme, difficulty FROM Questions";
$statement = $pdo->query($query);

// Vérifier si la requête s'est bien déroulée
if ($statement) {
    $questions = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($questions); // Renvoyer les données en format JSON
} else {
    echo json_encode(["error" => "Erreur lors de la récupération des questions"]);
}
?>
