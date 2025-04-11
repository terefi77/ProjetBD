

<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <title>SmartHealthRoom</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <head>
    <body>
        <header class="row">
            <div class="col-12">
                <h1>SmartHealthRoom</h1>
            </div>
        </header>
        <div class="wrapper row2">
		<div id="container" class="clear">
			<!-- bannière -->""
			<section id="banner" class="clear">
				<figure>
                    <div class="row">
					<img class="col-12" src="/image//img.jpg" alt="">
					<figcaption>
						<h3>Connectez-vous!</h3>
						<?php
						if(!isset($_SESSION)){
    						session_start();
						}
						$_SESSION['pseudo']='';?>

						<form action="veriflogin.php" method="post">
							<fieldset>
								<label for="pseudoi">Email: </label>
								<input type="text" name="pseudo" id="email" required><br>
								<label for="pwd">Mot de passe : </label>
								<input type="password" name="pwd" id="pwd" required><br>
								<input type="submit" value="Se Connecter"> 
								<input type="reset" value="Annuler">
								<!-- <p> 
								/*<?php 
									echo $_SESSION['message'];
								?></p> -->
							</fieldset>
						</form>
						<p> <a href="inscription.php">S'inscrire</a>
					</figcaption>
				</figure>
			</section>

		</div>
	</div>
	<?php  require('footer.php'); ?>



    </body>
