<?php
$mdp = 'admin';
if (isset($_POST['mdp']) AND $_POST['mdp'] == $mdp)
{
    header( 'Location: admin_cursus.php' ); // Redirige vers l'accueil du site
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('include/head.php'); ?>
        <title>Espace Administrateurs</title>
    </head>
    
    <body>
        <?php include('include/menu.php'); ?>
        <?php include('include/topbar.php'); ?>
        <div>
            <p>Veuillez entrer le mot de passe pour accéder à tous les cursus des étudiants :</p>
            <form action="admin.php" method="post">
                <p>
                <label for="mdp">Mot de passe :</label>
                <input type="password" name="mdp" />
                <input type="submit" value="Valider" />
                </p>
            </form>
            <p>Cette page est réservée aux responsables de la branche ISI de l'UTT !</p>
        </div>
    </body>
</html>