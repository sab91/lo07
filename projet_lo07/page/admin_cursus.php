<?php //session_start(); ?>

<!DOCTYPE html>
<html>
    <head>
        <?php include('include/head.php'); ?>
        <title>Espace Administrateurs</title>
    </head>
    
    <body>
        <?php include('include/menu.php'); ?>
        <?php include('include/topbar.php'); ?>
        <?php include('include/mysqli_connect.php'); ?>
        
        <div>
            <form action="admin_cursus.php" method="get">
                <label for="n_etu" >Numéro étudiant (5 chiffres) : </label>
                <?php input_datalist('numero_etu', 'etudiant', 'n_etu_input', 'n_etu_list', 'text'); ?>
                <br>
                <p>
                Réglement actuel <input type="radio" name="regle" value="actuel"><br>
                Futur réglement <input type="radio" name="regle" value="futur"><br>
                <input type="submit" value="Voir">
                </p>
            </form>
        </div>
        
        <div>
        <?php
        $data_exist = mysqli_query($bdd, 'SELECT * FROM cursus')or die(mysql_error());
        if(mysqli_num_rows($data_exist) >= 1)
        {
        // table cursus est renseignée
            
            //si l'étudioant n'existe pas encore dans la base
            if(isset($_GET['n_etu_input'])) {
                
                $n_etu = $_GET['n_etu_input'];
                $cursus_exist = mysqli_query($bdd, "SELECT * FROM cursus WHERE n_etu='$n_etu' ");
                if(mysqli_num_rows($cursus_exist) == 0) {
                    echo 'L\'étudiant n\'est pas enregistré dans la base';
                }
                else {
                
                    //Avec réglement actuel
                    if (isset($_GET['regle']) && $_GET['regle'] === 'actuel') {
                        $n_etu = $_GET['n_etu_input'];
                        include('include/tableau_actuel_cursus.php');


                    }
                    //Avec réglemnt futur
                    else if(isset($_GET['regle']) && $_GET['regle'] === 'futur') {
                        $n_etu = $_GET['n_etu_input'];
                        //connexion a la bdd
                        include('include/tableau_futur_cursus.php');


                    } else if(! isset($_GET['regle'])) {
                        echo 'Vérifiez le formulaire, <br>
                        Entrer le numéro étudiant et choississez le type de réglement <br>';
                    }
                }
            }
            //} else {echo 'L\'étudiant n\'est pas enregistré dans la base';}
            
        } else {
        // table cursus vide 
            echo 'Aucune données n\'a été rentré dans la base de données';
        } 
        ?>

        </div>
    </body>
</html>