<!DOCTYPE html>
<html>
    <head>
        <?php include('include/head.php'); ?>
        <title>Ajouter un Cursus</title>
    </head>
    
    <body>
        <?php include('include/menu.php'); ?>
        <?php include('include/topbar.php'); ?>       
        <div id="content">
            <form action="addcursus.php" method="post" enctype="multipart/form-data" id=form >
                <h1>Import du cursus</h1>
                <p>Il est possible d'importer un cursus depuis un fichier .csv, sinon il est possible de rentrer les données directement dans le formulaire ci-dessous. </p>
                <p>Importer un cursus (.csv) : </p>
                <input type="file" name="cursus" /><br>
                
                <?php
                //importer un cursus
                if (isset($_FILES['cursus'])) {
                    //connexion a la bdd
                    include('include/mysqli_connect.php');
                    //ouverture du fichier 
                    $fichier = fopen("C:/wamp64/www/projet_lo07/csv/" . $_FILES['cursus']['name'],"r"); 
                    //lecture du fichier
                    $data = fread($fichier, filesize("C:/wamp64/www/projet_lo07/csv/" . $_FILES['cursus']['name']));
                    //séparer le fichier en ligne
                    $lines = explode("\n", $data);

                    // traitement du fichier pour en voyer vers la bdd
                    //explode pour traiter mot par mot
                    foreach($lines as $data) {
                        switch($data[0] . $data[1]) {
                            case 'ID': 
                                list($type,$id_etu) = explode(';', $data);
                                break;
                            case 'NO': 
                                list($type,$nom) = explode(';', $data);
                                break;
                            case 'PR': 
                                list($type,$prenom) = explode(';', $data);
                                break;
                            case 'AD': 
                                list($type,$admission) = explode(';', $data);
                                break;
                            case 'FI': 
                                list($type,$fi) = explode(';', $data);
                                break;
                            case 'EL': 
                                list($type, $s_seq, $s_label, $sigle, $categorie, $affectation, $utt, $profil, $credit, $resultat) = explode(';', $data);

                                $select_el_formation = mysqli_query($bdd, "SELECT * FROM elem_formation WHERE sem_seq='$s_seq' AND sem_label='$s_label' AND sigle='$sigle' AND credit='$credit' AND resultat='$resultat'");
                                //si la ligne existe deja dans la base récuperer l'id de cette ligne
                                if (mysqli_num_rows($select_el_formation) > 0) {
                                    while($row = mysqli_fetch_assoc($select_el_formation)) {
                                        $id_elem_form = $row['id'];
                                    }
                                //sinon inserer une nouvelle ligne de données
                                } else {
                                    //insert dans la bdd pour les éléments du cursus
                                    $insert_el_formation = mysqli_query($bdd, "INSERT INTO elem_formation(sem_seq, sem_label, sigle, categorie, affectation, utt, profil, credit, resultat) VALUES('$s_seq','$s_label','$sigle','$categorie','$affectation','$utt','$profil','$credit','$resultat')");
                                    //recuperer l'id de la nouvelle ligne insérer
                                    $id_elem_form = mysqli_insert_id($bdd);
                                }
                                //ajout des données dans la table cursus
                                $insert_cursus = mysqli_query($bdd, "INSERT INTO cursus VALUES('$id_etu','$id_elem_form',NOW())");       //NOW() permet de recuperer la date et l'heure actuel             
                                break;
                        }
                    }

                    //insert des info de l'étudiant dans la table 'etudiant'
                    $insert_info_etu = mysqli_query($bdd, "REPLACE INTO etudiant VALUES('$id_etu','$nom','$prenom','$admission','$fi')");
                    /*if ($insert_info_etu) {
                        echo "Données enregistrées<br>";
                    } else {
                        echo "Error: " . $insert_info_etu . "<br>" . mysqli_error($bdd);
                    }*/

                    fclose($fichier);            
                    //echo '<br>';

                    //télécharger fichier et le placer dans le dossier indiqué
                    $dossier = "C:/wamp64/www/projet_lo07/csv/";
                    $fichier = basename($_FILES['cursus']['name']);
                    $resultat = move_uploaded_file($_FILES['cursus']['tmp_name'], $dossier . $fichier);
                    // test fichier (succès de l'opération ?)
                    if ($resultat) {echo "Transfert réussi<br>";}
                    else {echo 'problème';}
                    
                    //ajouter le mdp à la table authentification
                    $mdp = $_POST['mdp'];
                    $register_mdp = mysqli_query($bdd, "REPLACE INTO authentification VALUES('$id_etu','$mdp') ");
                }
                ?>
                <p>Il est necessaire de creer un mot de passe afin d'acceder à votre cursus par la suite.</p>
                <p><label for="mdp">Mot de passe :</label>
                    <input type="password" name="mdp" required /></p>
                <input type="submit" name="Importer" value="Importer">
            </form>
            <br>
            <form action="cursus.php" method="post" enctype="multipart/form-data">
                <div class=info_perso_etu>
                    <h1>Informations étudiant</h1>
                    <p>
                        
                        <?php 
                        include('include/mysqli_connect.php');

                                        
                        input_form('Nom', 'text', 'nom');
                        input_form('Prénom', 'text', 'prenom');
                        input_form('N° étu', 'number', 'n_etu');
                        ?>
                    </p>
                   <label for="admission" >Etudiant admis en : </label><br>
                    TC (Post Bac) <input type="radio" name="admission" value="TC" id="tc" onchange="                            
                            if (this.checked) {
                                $('#tc_plusdiv').css('display', 'block');
                                $('input[name=filiere]').prop('checked', false);
                            }" ><br>
                    <div class="tc_plus" id="tc_plusdiv">
                        TC5 <input type="checkbox" name="tc_plus" value="TC5" >
                        TC6 <input type="checkbox" name="tc_plus" value="TC6" ><br>
                    </div>
                    Branche (BAC +2) <input type="radio" name="admission" value="Branche" id="branche" onchange="
                            if (this.checked) {
                                $('#tc_plusdiv').css('display', 'none');
                                $('input[name=tc_plus]').prop('checked', false);
                            }" checked><br>
                    <label for="niveau_actuel">Niveau actuel : </label><br>
                    TC <input type="radio" name="admission" value="TC" id="tc" onchange="                            
                            if (this.checked) {
                                $('#filiere_div').css('display', 'none');
                                $('input[name=filiere]').prop('checked', false);
                            }" ><br>
                    Branche <input type="radio" name="admission" value="Branche" id="branche" onchange="
                            if (this.checked) {
                                $('#filiere_div').css('display', 'block');
                                $('input[name=tc_plus]').prop('checked', false);
                            }" checked><br>
                    <div class="filiere" id="filiere_div">
                        Filière : <select name="filiere">
                            <option value="?">TCBR</option>
                            <option value="MPL">MPL</option>
                            <option value="MSI">MSI</option>
                            <option value="MRI">MRI</option>
                            <option value="LIB">Libre</option>
                        </select>
                        
                    </div>
                </div>
                <br>
                <div class="info_cursus_etu">
                    <table>
                        <?php /*element_cursus();*/ ?>
                        <tr>
                            <td></td>
                            <td><?php input_datalist('sigle', 'elem_formation', 'choix_ue', '1' , 'ue1', 'text'); ?> </td>
                            
                        </tr>
                                                
                    </table>
                    
                </div>
                <input type="submit" value="Envoyer">
            </form>
            <div>
            
            </div>
        </div>
    </body>
</html>