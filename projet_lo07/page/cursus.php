<!DOCTYPE html>
<html>
    <head>
        <?php include('include/head.php'); ?>
        <title>Cursus</title>
    </head>
    <body>
        <?php include('include/menu.php') ?>
        <?php include('include/nav.php') ?>
        <div class="content">
            <?php if (isset($_GET['nom'])) { ?>
            Nom : <?php echo $_GET['nom']; ?><br>
            Prénom : <?php echo $_GET['prenom']; ?><br>
            N° étu : <?php echo $_GET['n_etu']; ?><br>
            Etudiant admis en : <?php echo $_GET['admission']; ?><br>
            <p>Ue suivie : <?php echo $_GET['ue']; ?></p>
            <?php }
            else {
                echo ("<p>Veuillez entrée des données !</p>");
            } ?>
        </div>
                
    </body>
</html>