<!-- save as index.html -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>
    <h2>Ajouter un étudiant</h2>
    <form action="add_student.php" method="POST">
        <label>Student ID:</label><br>
        <input type="text" name="student_id" required><br>
        <label>Name:</label><br>
        <input type="text" name="name" required><br>
        <label>Group:</label><br>
        <input type="text" name="group" required><br><br>
        <input type="submit" value="Ajouter">
    </form>
    <?php
// add_student.php

// Vérification si formulaire soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération et validation simple
    $student_id = trim($_POST['student_id']);
    $name = trim($_POST['name']);
    $group = trim($_POST['group']);

    if (empty($student_id)  empty($name)  empty($group)) {
        die("Erreur: Tous les champs sont obligatoires.");
    }

    $student = [
        "student_id" => $student_id,
        "name" => $name,
        "group" => $group
    ];

    $file = 'students.json';
    $students = [];

    // Charger les étudiants existants si le fichier existe
    if (file_exists($file)) {
        $json = file_get_contents($file);
        $students = json_decode($json, true);
        if (!is_array($students)) {
            $students = [];
        }
    }

    // Ajouter le nouvel étudiant
    $students[] = $student;

    // Sauvegarder dans students.json
    if (file_put_contents($file, json_encode($students, JSON_PRETTY_PRINT))) {
        echo "Étudiant ajouté avec succès!";
    } else {
        echo "Erreur lors de l'ajout de l'étudiant.";
    }
} else {
    echo "Méthode HTTP invalide.";
}
?>
</body>
</html>