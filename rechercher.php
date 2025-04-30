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
$email = $_SESSION['email'];
$sql_user = "SELECT * FROM utilisateur WHERE email = '$email'";
$res_user = mysqli_query($connexion, $sql_user);
$user = mysqli_fetch_assoc($res_user);
$motcle =$_POST['mots'];
$sql_patients = "
    SELECT p.*, c.numeroC, a.dateDeb
    FROM Patient p
    JOIN Affecter a ON p.idP = a.idP
    JOIN Chambre c ON a.idC = c.idC
    JOIN EtreResponsable er ON er.idC = c.idC
    WHERE er.idU = {$user['idU']}
    AND (
        p.nomP LIKE '%$motcle%' OR 
        p.prenomP LIKE '%$motcle%' OR 
        p.etatSante LIKE '%$motcle%' OR 
        c.numeroC LIKE '%$motcle%'
    )
";
$sql_chambres = "
    SELECT c.*
    FROM Chambre c
    JOIN EtreResponsable er ON er.idC = c.idC
    WHERE er.idU = {$user['idU']}
    AND (
        c.numeroC LIKE '%$motcle%' OR 
        c.etat LIKE '%$motcle%'
    )
";
$result_patients = mysqli_query($connexion, $sql_patients);
$result_chambres = mysqli_query($connexion, $sql_chambres);
$page_title = "Résultats de recherche";
require('entete.php');
?>
<div class="container mt-4">
    <h2>Résultats pour : <em><?php echo htmlspecialchars($motcle); ?></em></h2>
    <h3>Patients</h3>
    <?php
    if (mysqli_num_rows($result_patients) > 0) {
        echo '<div class="row">';
        while ($row = mysqli_fetch_assoc($result_patients)) {
            echo '<div class="col-md-4 mb-4">';
            $class = ($row['etatSante'] === 'Urgence' || $row['etatSante'] === 'Critique') ? 'border-danger' : '';
            echo '<div class="card ' . $class . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['nomP']) . ' ' . htmlspecialchars($row['prenomP']) . '</h5>';
            echo '<p class="card-text">';
            echo '<strong>État :</strong> ' . htmlspecialchars($row['etatSante']) . '<br>';
            echo '<strong>Chambre :</strong> ' . htmlspecialchars($row['numeroC']) . '<br>';
            echo '<strong>Date affectation :</strong> ' . htmlspecialchars($row['dateDeb']);
            echo '</p>';
            echo '</div></div></div>';
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-info">Aucun patient trouvé.</div>';
    }
    ?>
    <h3 class="mt-5">Chambres</h3>
    <?php
    if (mysqli_num_rows($result_chambres) > 0) {
        echo '<div class="row">';
        while ($row = mysqli_fetch_assoc($result_chambres)) {
            echo '<div class="col-md-4 mb-4">';
            $class = ($row['etat'] === 'Occupée') ? 'border-warning' : '';
            echo '<div class="card ' . $class . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">Chambre ' . htmlspecialchars($row['numeroC']) . '</h5>';
            echo '<p class="card-text">';
            echo '<strong>État :</strong> ' . htmlspecialchars($row['etat']) . '<br>';
            echo '<strong>Étage :</strong> ' . htmlspecialchars($row['etage']) . '<br>';
            echo '<strong>ID :</strong> ' . htmlspecialchars($row['idC']);
            echo '</p>';
            echo '</div></div></div>';
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-info">Aucune chambre trouvée.</div>';
    }
    ?>
</div>
<?php require('footer.php'); ?>
