<?php
// Démarrage de la session pour gérer l'utilisateur connecté
session_start();
// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
require('entete.php');
?>
<main class="container mt-5">
    <div class="form-wrapper mx-auto">
        <form method="post" action="affecter.php">
            <fieldset>
                <legend>Affecter un Patient à une Chambre</legend>
                <!-- Informations sur le patient -->
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="nomP" class="form-label">Nom du Patient</label>
                        <input type="text" name="nomP" id="nomP" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="prenomP" class="form-label">Prénom du Patient</label>
                        <input type="text" name="prenomP" id="prenomP" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="dateNaissance" class="form-label">Date de Naissance</label>
                        <input type="date" name="dateNaissance" id="dateNaissance" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="etatSante" class="form-label">État de Santé</label>
                        <select name="etatSante" id="etatSante" class="form-control" required>
                            <option value="Urgence">Urgence</option>
                            <option value="Critique">Critique</option>
                            <option value="Stable">Stable</option>
                        </select>
                    </div>
                </div>
                <!-- Informations sur l'affectation -->
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="numeroC" class="form-label">Numéro de Chambre</label>
                        <select name="numeroC" id="numeroC" class="form-control" required>
                            <?php
                            // Connexion à la base de données pour récupérer les chambres disponibles à la charge de l'utilisateur
                            require('connect.php');
                            $connexion = mysqli_connect("p:" . SERVEUR, NOM, PASSE, BD);
                            if (!$connexion) {
                                die("Erreur de connexion : " . mysqli_connect_error());
                            }
                            // Récupérer l'ID de l'utilisateur actuellement connecté (en session)
                            $email = $_SESSION['email'];
                            $sql_user = "SELECT idU FROM Utilisateur WHERE email = '$email'";
                            $res_user = mysqli_query($connexion, $sql_user);
                            $user = mysqli_fetch_assoc($res_user);
                            $idU = $user['idU'];
                            // Récupérer les chambres à la charge de l'utilisateur et qui sont disponibles
                            $sql_chambres = "
                                SELECT c.idC, c.numeroC 
                                FROM Chambre c 
                                JOIN EtreResponsable er ON c.idC = er.idC
                                WHERE er.idU = '$idU' AND c.etat ='Disponible'
                            ";
                            $result_chambres = mysqli_query($connexion, $sql_chambres);
                            while ($row = mysqli_fetch_assoc($result_chambres)) {
                                echo "<option value='" . $row['idC'] . "'>" . htmlspecialchars($row['numeroC']) . "</option>";
                            }
                            mysqli_close($connexion);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary me-2">Affecter le Patient</button>
                    <button type="reset" class="btn btn-secondary">Annuler</button>
                </div>
            </fieldset>
        </form>
    </div>
</main>
<?php
require('footer.php');
?>
