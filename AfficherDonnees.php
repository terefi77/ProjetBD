<?php 
session_start();
if (empty($_SESSION['email'])) {
    $_SESSION['message'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: login.php");
    exit();
}
require('connect.php');
$connexion = mysqli_connect("p:" . SERVEUR, NOM, PASSE, BD);
if (!$connexion) {
    echo"Erreur de connexion : " . mysqli_connect_error();
}
// Récupère les infos de l'utilisateur
$email=$_SESSION['email']; 
$sql_user="SELECT * FROM utilisateur WHERE email = '$email'";
$res_user=mysqli_query($connexion, $sql_user);
$user=mysqli_fetch_assoc($res_user);
// Récupère les données des dispositifs des chambres à la charge de l'utilisateur
$sql_donnees="
    SELECT d.nomDispo, don.valeur, don.dateD, c.numeroC
    FROM Donnees don
    JOIN Dispositif d ON don.idDispo = d.idDispo
    JOIN Chambre c ON d.idC = c.idC
    JOIN EtreResponsable er ON er.idC = c.idC
    WHERE er.idU = {$user['idU']}
    ORDER BY don.dateD DESC
";
$result_donnees=mysqli_query($connexion, $sql_donnees);
$page_title="Données des dispositifs";
require('entete.php');
?>
<div class="row">
    <div class="col-12">
        <h2>Données des dispositifs</h2>
        <?php 
        if (mysqli_num_rows($result_donnees) > 0) {
            echo '<div class="row">';
            while ($row = mysqli_fetch_assoc($result_donnees)) {
                echo '<div class="col-12 col-md-6 col-xl-4 mb-4">';
                    echo '<div class="card">';
                        echo '<div class="card-body">';
                            echo '<h5 class="card-title text-primary">'.htmlspecialchars($row['nomDispo']) . '</h5>';
                            echo '<p class="card-text">';
                                echo '<strong>Valeur :</strong> '.htmlspecialchars($row['valeur']) .'<br>';
                                echo '<strong>Chambre :</strong> '.htmlspecialchars($row['numeroC']) .'<br>';
                                echo '<strong>Date :</strong> '.htmlspecialchars($row['dateD']);
                            echo '</p>';
                        echo '</div>'; 
                    echo '</div>'; 
                echo '</div>'; 
            }
            echo '</div>';
        } else {
            echo '<div class="alert alert-info">Aucune donnée disponible pour vos chambres.</div>';
        }
        ?>
    </div>
</div>
<?php require('footer.php'); ?>