<?php 
session_start();
if (empty($_SESSION['email'])) {
    $_SESSION['message'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: login.php");
    exit();
}
require('connect.php');
$connexion = mysqli_connect("p:".SERVEUR, NOM, PASSE, BD);
if (!$connexion) {
    echo"Erreur de connexion : " . mysqli_connect_error();
}
//on récupère les infos de l'utilisateur
$email=$_SESSION['email']; 
$sql_user="SELECT * FROM utilisateur WHERE email = '$email'";
$res_user=mysqli_query($connexion, $sql_user);
$user=mysqli_fetch_assoc($res_user);
//on récupère toutes les alertes
$sql_alertes="
    SELECT a.*, d.nomDispo, c.numeroC
    FROM alerte a
    JOIN Dispositif d ON a.idDispo = d.idDispo
    JOIN Chambre c ON d.idC = c.idC
    JOIN EtreResponsable er ON er.idC = c.idC
    WHERE er.idU = {$user['idU']}
    ORDER BY a.dateA DESC
";
$result_alertes = mysqli_query($connexion, $sql_alertes);
$page_title = "Mes Alertes";
require('entete.php');
?>
<div class="row">
    <div class="col-12">
        <h2>Mes 🚨 Alertes</h2>
        <?php 
        if (mysqli_num_rows($result_alertes) > 0) {
            echo '<div class="row">';
            while ($row = mysqli_fetch_assoc($result_alertes)) {
                echo '<div class=" col-6 col-md-4 mb-4">';
                    if ($row['etatA']=='Non traité') {
                        echo '<div class="card border-danger">';
                    } else {
                        echo '<div class="card">';
                    }
                        echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . htmlspecialchars($row['type']) . '</h5>';
                            echo '<p class="card-text">';
                                echo '<small class="text-muted">' . $row['dateA'] . '</small><br>';
                                echo 'Chambre : ' . htmlspecialchars($row['numeroC']) . '<br>';
                                echo 'Dispositif : ' . htmlspecialchars($row['nomDispo']);
                            echo '</p>';
                            // Bouton ou message selon l'état
                            if ($row['etatA'] == 'Non traité') {
                                echo '<form method="POST" action="traiterAlerte.php" style="display:inline;">';
                                echo '<input type="hidden" name="idA" value="' . $row['idA'] . '">';
                                echo '<button type="submit" class="btn btn-danger btn-sm">Traiter🚨</button>';
                            echo '</form>';
                            } else {
                                echo '<p><strong>Déjà traité</strong></p>';
                            }
                        echo '</div>'; //card-body
                    echo '</div>'; //card
                echo '</div>'; //col
            }
            echo '</div>';// row
        } else {
            echo '<div class="alert alert-info">Aucune alerte pour le moment.</div>';
        }
        ?>
    </div>
</div>
<?php require('footer.php'); ?>

