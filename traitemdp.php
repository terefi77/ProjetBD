<?php
session_start();
require('connect.php');
//Connexion à la base de données
$connexion = mysqli_connect("p:" . SERVEUR, NOM, PASSE, BD);
if (!$connexion) {
    echo "Erreur de connexion :". mysqli_connect_error();
}
//on récupération des données du formulaire
$email =$_POST['email'];
$nouveau_mdp = $_POST['nouveau_mdp'];
$confirmation = $_POST['confirmation'];
// on vérifie si les mots de passe sont identiques
if ($nouveau_mdp !==$confirmation) {
    $_SESSION['message'] = "Les mots de passe ne correspondent pas.";
    header("Location: Reinitialisemdp.php");
    exit();
}
//on vérifie si l'utilisateur existe
$sql="SELECT * FROM Utilisateur WHERE email='$email'";
$res=mysqli_query($connexion, $sql);
if (mysqli_num_rows($res)===0) {
    $_SESSION['message']="Aucun compte trouvé avec cet email.";
    header("Location:Reinitialisemdp.php");
    exit();
}
//mise à jour du mot de passe dans la base
$sql_update="UPDATE Utilisateur SET mdp = '$nouveau_mdp' WHERE email ='$email'";
if (mysqli_query($connexion, $sql_update)) {
    $_SESSION['message'] = "Mot de passe mis à jour avec succès. Connectez-vous.";
    header("Location: login.php");
    exit();
} else {
    $_SESSION['message']="Erreur lors de la mise à jour du mot de passe.";
    header("Location: Reinitialisemdp.php");
    exit();
}
?>
