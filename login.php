<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>SmartHealthRoom-Connexion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</head>
<body>
  <header>
    <h1 class="text-center my-4"><em>SmartHealthRoom</em></h1>
  </header>
  <main class="login-page container mt-5">
    <div class="card d-flex flex-row flex-wrap">
      <div class="form-section p-4 col-12 col-md-6">
        <h2 class="mb-4 text-dark"><u><strong>Connexion!</strong></u></h2>
        <?php
        if (!isset($_SESSION)){
          session_start();
        }
        $_SESSION['email']='';?>
        <div class="form-login">
          <form action="veriflogin.php" method="post">
            <div class="mb-3 col-12 col-md-6">
              <label for="email" class="form-label">Adresse e-mail</label>
              <input type="text" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3 col-12 col-md-6">
              <label for="pwd" class="form-label">Mot de passe</label>
              <input type="password" name="pwd" id="pwd" class="form-control" required>
            </div>
            <input type="submit" value="Se connecter" class="btn btn-success mb-3">
            <input type="reset" value="Annuler" class="btn btn-secondary ms-2 mb-3">
          </form>
        </div>
        <p class="m-3">Pas encore inscrit ? <a href="inscription.php">Créer un compte</a></p>
        <p class="m-3">Mot de passe oublié ? <a href="Reinitialisemdp.php">Réinitialiser</a></p>
      </div>
      <div class="image-section col-12 col-md-6 d-flex align-items-center justify-content-center p-3">
        <img src="image/img.jpg" alt="Image de connexion" class="img-fluid rounded">
      </div>
    </div>
  </main>
  <?php require('footer.php'); ?>
</body>
</html>
