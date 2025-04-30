<?php
require('connect.php');
session_start();
$connexion=mysqli_connect("p:".SERVEUR, NOM, PASSE, BD);
if (!$connexion) {
    echo "<p>Problème : Connexion au serveur ".SERVEUR." ou à la base ".BD." impossible. <br/> Erreur : ".mysqli_connect_error()."</p>";
    exit();
}
$email=$_POST["email"];
$pwd=$_POST["pwd"];
$requete="SELECT email, mdp FROM utilisateur WHERE email='$email' AND mdp='$pwd'";
$resultat=mysqli_query($connexion, $requete);
if ($resultat) {
    if (mysqli_num_rows($resultat)==0) {
        $_SESSION['message']="Email ou mot de passe incorrect!";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['email']=$email;
        $_SESSION['message']='';
        header("Location: index.php");
        exit();
    }
} else {
    echo "<p>Erreur dans l'exécution de la requête</p>";
    echo mysqli_error($connexion);
}
?>
