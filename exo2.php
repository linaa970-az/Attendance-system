<!DOCTYPE html> 
<html lang="en"> 
<head> 
  <meta charset="UTF-8"> 
  <title>Add Student</title> 
  <style> 
    /* Votre style reste inchangé */ 
  </style> 
 
</head> 
<body> 
 
  <div class="container"> 
    <h2>Add Student</h2> 
    <form id="studentForm" action="add_student.php" method="POST"> 
      <div class="form-group"> 
        <label for="studentId">Student ID:</label> 
        <input type="text" id="studentId" name="studentId"> 
        <div class="error" id="idError"></div> 
      </div> 
 
      <div class="form-group"> 
        <label for="lastName">Last Name:</label> 
        <input type="text" id="lastName" name="lastName"> 
        <div class="error" id="lastNameError"></div> 
      </div> 
 
      <div class="form-group"> 
        <label for="firstName">First Name:</label> 
        <input type="text" id="firstName" name="firstName"> 
        <div class="error" id="firstNameError"></div> 
      </div> 
 
      <div class="form-group"> 
        <label for="email">Email:</label> 
        <input type="text" id="email" name="email"> 
        <div class="error" id="emailError"></div> 
      </div> 
 
      <button type="submit">Submit</button> 
    </form> 
  </div> 
 
<script> 
document.getElementById("studentForm").addEventListener("submit", function(event) { 
  event.preventDefault(); 
 
  // Effacer les erreurs 
  document.querySelectorAll(".error").forEach(e => e.textContent = ""); 
 
  const studentId = document.getElementById("studentId").value.trim(); 
  const firstName = document.getElementById("firstName").value.trim(); 
  const lastName = document.getElementById("lastName").value.trim(); 
  const email = document.getElementById("email").value.trim(); 
 
  let valid = true; 
 
  if (studentId === "" || !/^\d+$/.test(studentId)) { 
    document.getElementById("idError").textContent = "Student ID must contain only numbers."; 
    valid = false; 
  } 
 
  if (firstName === "" || !/^[A-Za-z]+$/.test(firstName)) { 
    document.getElementById("firstNameError").textContent = "First name must contain only letters."; 
    valid = false; 
  } 
 
  if (lastName === "" || !/^[A-Za-z]+$/.test(lastName)) { 
    document.getElementById("lastNameError").textContent = "Last name must contain only letters."; 
    valid = false; 
  } 
 
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 
  if (email === "" || !emailPattern.test(email)) { 
    document.getElementById("emailError").textContent = "Please enter a valid email."; 
    valid = false; 
  } 
 
  if (valid) { 
    // Si tout est valide, envoyer le formulaire 
    this.submit(); 
  } 
}); 
</script> 
<?php 
// Inclure le fichier de connexion à la base de données 
require_once 'db_connect.php'; 
 
// Vérifier si le formulaire est soumis 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Récupérer les données envoyées par le formulaire 
    $studentId = $_POST['studentId']; 
    $firstName = $_POST['firstName']; 
    $lastName = $_POST['lastName']; 
    $email = $_POST['email']; 
 
    // Validation simple des données (cela peut être étendu) 
    if (!empty($studentId) && !empty($firstName) && !empty($lastName) && !empty($email)) { 
        // Créer une connexion à la base de données 
        $pdo = getConnection(); // Utiliser la fonction getConnection() du fichier db_connect.php 
 
        if ($pdo) { 
            // Préparer la requête SQL pour insérer un étudiant 
            $sql = "INSERT INTO students (student_id, first_name, last_name, email) VALUES (:studentId, :firstName, :lastName, :email)"; 
 
            $stmt = $pdo->prepare($sql); 
            $stmt->bindParam(':studentId', $studentId); 
            $stmt->bindParam(':firstName', $firstName); 
            $stmt->bindParam(':lastName', $lastName); 
            $stmt->bindParam(':email', $email); 
 
            // Exécuter la requête 
            if ($stmt->execute()) { 
                echo "Student added successfully!"; 
            } else { 
                echo "Error: Could not add student."; 
            } 
        } else { 
            echo "Error: Could not connect to database.";
            } 
    } else { 
        echo "Please fill all fields."; 
    } 
} 
?> 
</body> 
</html>