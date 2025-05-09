<?php 
$error = "";
$success = "";

// Connexion à la base de données
$host = "localhost";
$dbname = "formulaire_db";  // Nom de ta base
$username = "root";         // Utilisateur par défaut (XAMPP)
$password_db = "";          // Mot de passe vide par défaut

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connexion échouée : " . $e->getMessage());
}

if(isset($_POST["sign_up_form"])){
    if (!empty($_POST["lastname"]) && !empty($_POST["firstname"]) && !empty($_POST["email"]) && !empty($_POST["password"])){
        $lastname = $_POST["lastname"];
        $firstname = $_POST["firstname"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hachage sécurisé

        // Requête SQL
        $sql = "INSERT INTO utilisateurs (lastname, firstname, email, password) 
                VALUES (:lastname, :firstname, :email, :password)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":lastname" => $lastname,
            ":firstname" => $firstname,
            ":email" => $email,
            ":password" => $password
        ]);

        $success = "Inscription réussie !";
    } else {
        $error = "L'un des champs n'est pas rempli.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            background-color: blanchedalmond;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background-color: bisque;
            padding: 20px;
            border: solid #000 1.5px;
            border-radius: 10px;
            width: 300px;
        }
        .form_component {
            display: flex;
            flex-direction: column;
            margin-top: 10px;
        }
        input {
            border-radius: 5px;
            border: solid 1px;
            outline: none;
            padding: 5px;
        }
        button {
            margin-top: 10px;
            padding: 8px;
            background-color: bisque;
            border: solid #000 1.5px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: blanchedalmond;
        }
        .message {
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="newform.php" method="post">
            <div class="message">
                <?php
                    if ($error) echo "<span style='color:red;'>$error</span>";
                    if ($success) echo "<span style='color:green;'>$success</span>";
                ?>
            </div>
            <div class="form_component">
                <label for="lastname">Nom</label>
                <input type="text" name="lastname">
            </div>
            <div class="form_component">
                <label for="firstname">Prénom</label>
                <input type="text" name="firstname">
            </div>
            <div class="form_component">
                <label for="email">Email</label>
                <input type="email" name="email">
            </div>
            <div class="form_component">
                <label for="password">Mot de passe</label>
                <input type="password" name="password">
            </div>
            <button name="sign_up_form">S'inscrire</button>
        </form>
    </div>
</body>
</html>
