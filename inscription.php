<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>SmartHealthRoom - Inscription</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>SmartHealthRoom</h1>
  </header>
  <main class="container mt-5">
    <div class="form-wrapper mx-auto">
      <form method="post" action="inscrire.php">
        <fieldset>
          <legend>Inscription</legend>
          <div class="row">
            <div class="col-12 col-md-6 mb-3">
              <label for="nom" class="form-label">Nom</label>
              <input type="text" name="nom" id="nom" class="form-control" required>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="prenom" class="form-label">Prénom</label>
              <input type="text" name="prenom" id="prenom" class="form-control" required>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="mdp" class="form-label">Mot de passe</label>
              <input type="password" name="mdp" id="mdp" class="form-control" required>
            </div>
            <div class="col-12 mb-4">
              <label for="poste" class="form-label">Poste</label>
              <input type="text" name="poste" id="poste" class="form-control" required>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary me-2">S'inscrire</button>
            <button type="reset" class="btn btn-secondary">Annuler</button>
          </div>
        </fieldset>
      </form>
      <div class="text-center mt-3">
        <a href="login.php" class="btn btn-link">←Retour à la connexion</a>
      </div>
    </div>
  </main>
</body>
</html>
            
    