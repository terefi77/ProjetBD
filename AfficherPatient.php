<?php 
session_start();
if (empty($_SESSION['email'])) {
    $_SESSION['message']="Vous devez être connecté pour accéder à cette page";
    header("Location: login.php");
    exit();
}
require('connect.php');
$connexion = mysqli_connect("p:".SERVEUR, NOM, PASSE, BD);
if (!$connexion) {
    die("Erreur de connexion : " . mysqli_connect_error());
}
// Récupère les infos de l'utilisateur
$email =  $_SESSION['email']; 
$sql_user = "SELECT * FROM utilisateur WHERE email = '$email'";
$res_user = mysqli_query($connexion, $sql_user);
$user = mysqli_fetch_assoc($res_user);
// Récupère toutes les alertes
$sql_patients ="
    SELECT p.*,c.numeroC,a.dateDeb
    FROM patient p
    JOIN Affecter a ON p.idP = a.idP
    JOIN Chambre c ON a.idC = c.idC
    JOIN EtreResponsable er ON er.idC = c.idC
    WHERE er.idU = {$user['idU']} and c.etat='Occupée'
    ORDER BY a.dateDeb DESC 
";
$result_patients=mysqli_query($connexion, $sql_patients);
$page_title="Patients";
require('entete.php');
?>

<div class="row">
    <div class="col-12">
        <h2>Patients</h2>
        <?php 
        if (mysqli_num_rows($result_patients) > 0) {
            echo '<div class="row">';
            while ($row = mysqli_fetch_assoc($result_patients)) {
                echo '<div class=" col-6 col-md-4 mb-4">';
                    // Met un bord rouge si l'alerte est non traitée
                    if ($row['etatSante']=='Urgence' || $row['etatSante']=="Critique") {
                        echo '<div class="card border-danger">';
                    } else {
                        echo '<div class="card">';
                    }
                        echo '<div class="card-body">';
                            echo '<h5 class="card-title">' .htmlspecialchars($row['nomP']) . '</h5>';
                            echo '<h5 class="card-title">' .htmlspecialchars($row['prenomP']) . '</h5>';
                            echo '<p class="card-text">';
                                echo '<strong>Etat:</strong>';
                                echo '<small class="text-muted">'.$row['etatSante'] .'</small><br>';
                                echo 'Chambre : ' .htmlspecialchars($row['numeroC']) .'<br>';
                                echo 'DateAffecté: ' .htmlspecialchars($row['dateDeb']);
                            echo '</p>';
                        echo '</div>'; 
                    echo '</div>'; 
                echo '</div>'; 
            }
            echo '</div>';
        } else {
            echo '<div class="alert alert-info">Aucun patient Est a votre charge.</div>';
        }
        ?>
    </div>
</div>
<?php require('footer.php'); ?>