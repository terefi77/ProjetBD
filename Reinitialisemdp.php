<?php require('entete.php'); ?>
<?php session_start(); ?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h3 class="text-center mb-4 text-success">Réinitialiser le mot de passe</h3>
      <?php
      if (isset($_SESSION['message'])) {
          echo "<div class='alert alert-warning text-center'>" . $_SESSION['message'] . "</div>";
      }
      ?>
      <form method="post" action="traitemdp.php">
        <div class="mb-3">
          <label for="email" class="form-label">Adresse Email</label>
          <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="nouveau_mdp" class="form-label">Nouveau mot de passe</label>
          <input type="password" name="nouveau_mdp" id="nouveau_mdp" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="confirmation" class="form-label">Confirmer le mot de passe</label>
          <input type="password" name="confirmation" id="confirmation" class="form-control" required>
        </div>
        <div class="d-grid">
          <input type="submit" class="btn btn-success" value='Réinitialiser'>
        </div>
      </form>
      <div class="text-center mt-3">
        <a href="login.php" class="btn btn-link">←Retour à la connexion</a>
      </div>

    </div>
  </div>
</div>

<?php require('footer.php'); ?>
