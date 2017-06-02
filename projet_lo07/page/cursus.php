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
        
        <div>
            <form action="cursus.php" method="get">
                Réglement actuel <input type="radio" name="regle" value="actuel"><br>
                Futur réglement <input type="radio" name="regle" value="futur"><br>
                <input type="submit" value="Voir">
            </form>
        </div>
        <div>
            <?php
            //connexion a la base
            include('include/mysqli_connect.php');
            
            if (isset($_SESSION['n_etu']) && isset($_GET['regle']) && $_GET['regle'] === 'actuel') {
                $n_etu = $_SESSION['n_etu'];
                include('include/tableau_actuel_cursus.php');
                //variable de session
            $nom = $_SESSION['nom'];
            $prenom = $_SESSION['prenom'];
            
//===============création fichier CSV si necessaire =====================               
            //vérifier l'existence d'un fichier csv pour l'étudiant concerné sinon le créer pour pouvoir l'exporter
            if(! file_exists("../csv/".$nom."_".$prenom.".csv")) {
                
                //chemin du fichier
                $path = "../csv/".$nom."_".$prenom.".csv";
                
                $titre = array('ID','NO','PR','AD','FI');
                
                //chercher les données perso de l'étudiant
                $info_etu = mysqli_query($bdd, "SELECT * FROM etudiant where numero_etu=$n_etu");
                $row = mysqli_fetch_row($info_etu);
                //ecrire dnas le fichier csv les données
                foreach($titre as $key => $element){
                    file_put_contents($path, $titre[$key].";".$row[$key].";;;;;;;;\n", FILE_APPEND);
                }
                
                $titre = "==;s_seq;s_label;sigle;categorie;affectation;utt;profil;credit;resultat\n";
                file_put_contents($path, $titre, FILE_APPEND);
                
                //chercher les éléments de formation de l'étudiant
                $elem_form_etu = mysqli_query($bdd, "SELECT elem_formation.sem_seq, elem_formation.sem_label, elem_formation.sigle, elem_formation.categorie, elem_formation.affectation, elem_formation.utt, elem_formation.profil, elem_formation.credit, elem_formation.resultat FROM elem_formation, cursus WHERE n_etu='$n_etu' and elem_formation.id=cursus.id_elem_formation ORDER BY sem_seq");
                //écrire les données pour chaque élément de formation sur une ligne
                while ($row = mysqli_fetch_row($elem_form_etu))
                {
                    $row = implode(';', $row);
                    file_put_contents($path, "EL;".$row, FILE_APPEND);
                }
                
                file_put_contents($path, "END;;;;;;;;;", FILE_APPEND);
                
//===================  fin création fichier CSV ======================        
                
                echo '<br>';
                echo "<a href='../csv/".$nom."_".$prenom.".csv'>Exporter son cursus au format .csv</a>";
                
            } else {
                echo '<br>';
                echo "<a href='../csv/".$nom."_".$prenom.".csv'>Exporter son cursus au format .csv</a>";
            }
                    
            } else if(isset($_SESSION['n_etu']) && isset($_GET['regle']) && $_GET['regle'] === 'futur') {
                $n_etu = $_SESSION['n_etu'];
                include('include/tableau_futur_cursus.php');
                
                //variable de session
            $nom = $_SESSION['nom'];
            $prenom = $_SESSION['prenom'];
            
//===============création fichier CSV si necessaire =====================               
            //vérifier l'existence d'un fichier csv pour l'étudiant concerné sinon le créer pour pouvoir l'exporter
            if(! file_exists("../csv/".$nom."_".$prenom.".csv")) {
                
                //chemin du fichier
                $path = "../csv/".$nom."_".$prenom.".csv";
                
                $titre = array('ID','NO','PR','AD','FI');
                
                //chercher les données perso de l'étudiant
                $info_etu = mysqli_query($bdd, "SELECT * FROM etudiant where numero_etu=$n_etu");
                $row = mysqli_fetch_row($info_etu);
                //ecrire dnas le fichier csv les données
                foreach($titre as $key => $element){
                    file_put_contents($path, $titre[$key].";".$row[$key].";;;;;;;;\n", FILE_APPEND);
                }
                
                $titre = "==;s_seq;s_label;sigle;categorie;affectation;utt;profil;credit;resultat\n";
                file_put_contents($path, $titre, FILE_APPEND);
                
                //chercher les éléments de formation de l'étudiant
                $elem_form_etu = mysqli_query($bdd, "SELECT elem_formation.sem_seq, elem_formation.sem_label, elem_formation.sigle, elem_formation.categorie, elem_formation.affectation, elem_formation.utt, elem_formation.profil, elem_formation.credit, elem_formation.resultat FROM elem_formation, cursus WHERE n_etu='$n_etu' and elem_formation.id=cursus.id_elem_formation ORDER BY sem_seq");
                //écrire les données pour chaque élément de formation sur une ligne
                while ($row = mysqli_fetch_row($elem_form_etu))
                {
                    $row = implode(';', $row);
                    file_put_contents($path, "EL;".$row, FILE_APPEND);
                }
                
                file_put_contents($path, "END;;;;;;;;;", FILE_APPEND);
                
//===================  fin création fichier CSV ======================        
                
                echo '<br>';
                echo "<a href='../csv/".$nom."_".$prenom.".csv'>Exporter son cursus au format .csv</a>";
                
            } else {
                echo '<br>';
                echo "<a href='../csv/".$nom."_".$prenom.".csv'>Exporter son cursus au format .csv</a>";
            }

            } else {
                echo 'Entrer votre numéro et choississez le réglement voulut <br>';
            }
            
            ?>
        </div>
    </body>
</html>