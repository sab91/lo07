<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('include/head.php'); ?>
        <title>Cursus</title>
    </head>
    <body>
        <?php include('include/menu.php'); ?>
        <?php include('include/topbar.php'); ?>

        <?php
        include('include/mysqli_connect.php');
        if(! isset($_POST['login'])) {$n_etu = null;}
        else {
            $n_etu = $_POST['login'];
            $select_mdp = mysqli_query($bdd, "SELECT mdp FROM authentification WHERE n_etu='$n_etu' ");
            $mdp = null;
            while ($row = mysqli_fetch_row($select_mdp))
            {
                $mdp = $row[0];
            }
        }
        ?>
        
        <!-- se connecter pour avoir accès à son cursus -->
        <?php if(! isset($_POST['mdp'])) { ?>
        <form action="auth_cursus.php" method="post">
            <label for="login">Nom : </label>
            <input type="text" name="nom" required /><br>
            <label for="login">Prénom : </label>
            <input type="text" name="prenom" required /><br>
            <label for="login">Numéro étudiant : </label>
            <input type="text" name="login" required /><br>
            <label for="mdp" >Mot de passe : </label>
            <input type="password" name="mdp" required /><br>
            <input type="submit" value="Se connecter" />
        </form>
        
        <!-- Dans le cas ou le login et mdp ne correspondent pas -->
        <?php } else if(isset($_POST['mdp']) && $_POST['mdp'] != $mdp) { ?>
        <form action="auth_cursus.php" method="post">
            <label for="login">Numéro étudiant : </label>
            <input type="text" name="login" required /><br>
            <label for="mdp" >Mot de passe : </label>
            <input type="password" name="mdp" required /><br>
            <input type="submit" value="Se connecter" />
        </form>
        <p>Mot de passe et Login ne correspondent pas</p>
        <p>Veuillez réessayer</p>
        <?php } else { ?>
        <p>L'authentification a réussi</p>
        <form action="cursus.php" method="get">
            <input type="submit" value="Accéder au cursus" />
            <?php 
                $_SESSION['n_etu'] = $n_etu;
                $_SESSION['nom'] = strtoupper($_POST['nom']);
                $_SESSION['nom'] = str_replace(' ','_',$_SESSION['nom']);
                $_SESSION['prenom'] = strtolower($_POST['prenom']);
            ?>
        </form>
        <?php } ?>
    </body>
</html>