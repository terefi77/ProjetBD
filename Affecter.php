<?php
//on prolonge la session pour gérer l'utilisateur connecté
session_start();
//on vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
    // on recupére les données soumises via le formulaire
    $nomP=$_POST['nomP'];
    $prenomP=$_POST['prenomP'];
    $dateNaissance=$_POST['dateNaissance'];
    $etatSante=$_POST['etatSante'];
    $numeroC=$_POST['numeroC'];
    //Connexion à la base de données
    require('connect.php');
    $connexion = mysqli_connect("p:" . SERVEUR, NOM, PASSE, BD);
    if (!$connexion) {
        echo "Erreur de connexion : " . mysqli_connect_error();
    }
    // on récupére l'ID de l'utilisateur connecté
    $email = $_SESSION['email'];
    $sql_user = "SELECT idU FROM Utilisateur WHERE email = '$email'";
    $res_user = mysqli_query($connexion, $sql_user);
    $user = mysqli_fetch_assoc($res_user);
    $idU = $user['idU']; 
    // on vérifie si la chambre est disponible
    $sql_chambre = "SELECT etat FROM Chambre WHERE idC='$numeroC' AND etat = 'Disponible'";
    $result_chambre = mysqli_query($connexion, $sql_chambre);
    if (mysqli_num_rows($result_chambre) > 0) {
        //on insérer le patient dans la table des patients (si nécessaire)
        $sql_patient="INSERT INTO Patient(nom, prenom, dateNaissance, etatSante) 
                        VALUES('$nomP', '$prenomP', '$dateNaissance', '$etatSante')";
        if (mysqli_query($connexion, $sql_patient)) {
            //on récupérer l'ID du patient nouvellement ajouté
            $idP=mysqli_insert_id($connexion);
            //on insérer l'affectation du patient à la chambre
            $sql_affectation="INSERT INTO Affecter (idP, idC) VALUES ('$idP', '$numeroC')";
            if (mysqli_query($connexion, $sql_affectation)) {
                //mise à jour de l'état de la chambre (indisponible)
                $sql_update_chambre="UPDATE Chambre SET etat='Occupée' WHERE idC='$numeroC'";
                if (mysqli_query($connexion, $sql_update_chambre)) {
                    //on rediriger avec un message de succès
                    $_SESSION['message']="Le patient a été affecté à la chambre avec succès.";
                    header("Location: affecter_patient.php");
                    exit();
                } else {
                    echo"Erreur lors de la mise à jour de l'état de la chambre.";
                }
            } else {
                $_SESSION['error']="Erreur lors de l'affectation du patient à la chambre.";
            }
        } else {
            $_SESSION['error']="Erreur lors de l'ajout du patient.";
        }
    } else {
        $_SESSION['error']="La chambre n'est pas disponible ou n'existe pas.";
    }
    //on ferme la connexion
    mysqli_close($connexion);
    //on redirection vers la page d'affectation avec un message d'erreur
    header("Location:affecter_patient.php");
    exit();
?>
