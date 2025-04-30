<?php
session_start();
require_once('connect.php');
require_once('entete.php');
$connexion = mysqli_connect("p:" . SERVEUR, NOM, PASSE, BD);
if (!$connexion) {
    echo"Erreur de connexion : " . mysqli_connect_error();
}
//on vérifie si l'utilisateur est connecté
if (empty($_SESSION['email'])) {
    $_SESSION['message']="Vous devez être connecté.";
    header("Location: login.php");
    exit();
}
//on récupère l'idU de l'utilisateur connecté
$email=$_SESSION['email'];
$sql_user="SELECT idU FROM Utilisateur WHERE email = '$email'";
$res_user=mysqli_query($connexion, $sql_user);
$user=mysqli_fetch_assoc($res_user);
$idU=$user['idU'];
// Si le formulaire est soumis
if (isset($_POST['valider'])) {
    $idA=$_POST['idA'];
    $dateTraitement=$_POST['dateTraitement'];
    $commentaire=$_POST['commentaire'];
    // Insertion dans la table Traiter
    $insert_sql="
        INSERT INTO Traiter (idU, idA, DateDeb, DateTraiment, commentaire)
        VALUES ($idU, $idA, NOW(), '$dateTraitement', '$commentaire')
    ";
    // on fait mise à jour de l'état de l'alerte
    $update_sql="UPDATE Alerte SET etatA='Traité' WHERE idA=$idA";
    $ok_insert=mysqli_query($connexion, $insert_sql);
    $ok_update=mysqli_query($connexion, $update_sql);
    if ($ok_insert && $ok_update) {
        echo "<div class='alert alert-success'>Alerte traitée avec succès.</div>";
        echo '<a href="AfficherAlerte.php" class="btn btn-primary mt-3">Retour aux alertes</a>';
    } else {
        echo "<div class='alert alert-danger'>Erreur : " . mysqli_error($connexion) . "</div>";
    }
}
// Si on a reçu un idA pour afficher le formulaire (en POST aussi)
elseif (isset($_POST['idA'])) {
    $idA=$_POST['idA'];
    $sql="SELECT * FROM Alerte WHERE idA = $idA";
    $result=mysqli_query($connexion, $sql);
    $alerte=mysqli_fetch_assoc($result);
    if (!$alerte) {
        echo "<div class='alert alert-danger'>Alerte introuvable.</div>";
    } else {
        ?>
        <div class="container mt-5">
            <h3>Traiter l'alerte : <?php echo htmlspecialchars($alerte['type']); ?></h3>
            <form method="POST" action="traiterAlerte.php">
                <input type="hidden" name="idA" value="<?php echo $alerte['idA']; ?>">
                <div class="mb-3">
                    <label for="dateTraitement" class="form-label">Date de traitement</label>
                    <input type="date" class="form-control" name="dateTraitement" required>
                </div>
                <div class="mb-3">
                    <label for="commentaire" class="form-label">Commentaire (facultatif)</label>
                    <textarea class="form-control" name="commentaire" rows="3"></textarea>
                </div>
                <button type="submit" name="valider" class="btn btn-success">Valider le traitement</button>
                <a href="AfficherAlerte.php" class="btn btn-secondary">Retour</a>
            </form>
        </div>
        <?php
    }
} else {
    echo "<div class='alert alert-warning'>Aucune alerte à traiter.</div>";
    echo '<a href="AfficherAlerte.php" class="btn btn-secondary mt-3">Retour</a>';
}
require_once('footer.php');
mysqli_close($connexion);
?>
