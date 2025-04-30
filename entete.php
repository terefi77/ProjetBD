<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <title>SmartHealthRoom - <?php echo $page_title ?? 'Tableau de bord'; ?></title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <head>
    <body>
        <form action="rechercher.php" method="post">
            <fieldset>
            <legend>Recherche:</legend>
            <!-- un tout petit peu de JavaScript pour mettre le champ de saisie à vide au clic utilisateur -->
            <input type="text" value="Un artiste, un album, une musique&hellip;" onFocus="this.value=(this.value=='Un artiste, un album, une musique&hellip;')? '' : this.value ;" name="mots">
            <input type="submit" id="sf_submit" value="Recherche">
            </fieldset>
        </form>
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
            <div class="container">
                <a class="navbar-brand text-success" href="#">SmartHealthRoom</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="AfficherPatient.php">Patients</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="AfficherAlerte.php">Alertes</a></li>
                    <li class="nav-item"><a class="nav-link" href="AfficherDonnees.php">Données</a></li>
                    <li class="nav-item"><a class="nav-link" href="AffecterPatient.php">Affecter</a></li>
                    <li class="nav-item"><a class="nav-link" href="AfficherChambre.php">Chambre</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="login.php">Déconnexion</a></li>
                </ul>
                </div>
            </div>
        </nav>
        <div class="container">