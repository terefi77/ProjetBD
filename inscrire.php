<?php  require('connect.php')?>; 
<?php

    $connexion = mysqli_connect("p:".SERVEUR, NOM, PASSE,BD);
    if (!$connexion)
    {
        echo "<p>Problème : Connexion au serveur ".SERVEUR." ou à la base ".BD." impossible. <br/> Erreur : ".mysqli_error()."</p>";
    }
    $nom=$_post["nom"];
    $prenom=$_post["prenom"];
    $email=$_post["email"];
    $mdp=$_post["mdp"];
    $date=$_post["datedeb"];
    $etablissemnt=$_post["etablissement"];
    $poste=$_post["poste"]
    $requete="insert into utilisateur (nomU,prenomU,email,mdp,poste) values('.$nom.','.$prenom','.$email','.$mdp','.$poste.');";
    $resulat=($connexion,$requete);
    if($resulat){
        echo "Insertion utilisateur reussie avec success✅"
    }
    else{
        echo mysqli_error($connexion);
    }
    $idU="select idU from utilisateur where nomU='$nom' and prenomU='$prenom'";
    $idE="select idE from etablissement where nomE='$etablissement'";
    $requete1="insert into travailler(idE,idU ,dateDeb)values('.$idE.','.$dU.','.$date.');";
    $resulat1=($connexion,$requete1);
    if($resulat1){
        echo "Insertion  reussie avec success✅"
    }
    else{
        echo mysqli_error($connexion);
    }
    fclose($connexion);
?>