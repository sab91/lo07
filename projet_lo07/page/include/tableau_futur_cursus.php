<?php

    //ouverture du fichier 
    $fichier = fopen("C:/wamp64/www/projet_lo07/csv/R_FUTUR_BR.csv","r"); 
    //lecture du fichier
    $data = fread($fichier, filesize("C:/wamp64/www/projet_lo07/csv/R_FUTUR_BR.csv"));
    //séparer le fichier en ligne
    $lines = explode("\n", $data);

    //pour chaque ligne du fichier traiter seulement celle commençant par R
    foreach($lines as $data) {
        if($data[0] == 'R') {
            //lister les elements d'une ligne
            list($label,$method,$categorie,$affectation,$credit_min) = explode(';', $data);
            //select dans la bdd selon les données qu'on a
            $select_regle = select_credit($n_etu, $method, $categorie, $affectation);
            //récupération dans un array des crédits obtenus pour les différents règles
            $credit_obtenu[$label] = $select_regle;
            //stocker le nombre de crédit minimum pour chaque règle dans un array
            $array_credit_min[$label] = $credit_min;
            //array categorie par règles
            $array_categorie[$label] = $categorie;
            //array affectation par règles
            $array_affectation[$label] = $affectation;
        }
    }

    //affichage pour vériffier les valeurs des array
    //print_r($credit_obtenu);
    //print_r($array_credit_min);

    fclose($fichier);            
    echo '<br>';

    //Savoir la dernière date de modification des données par l'utilisateur
    $select_date_modif = mysqli_query($bdd, "SELECT date_modif FROM cursus WHERE n_etu=$n_etu ORDER BY date_modif DESC LIMIT 1");
    while ($row = mysqli_fetch_row($select_date_modif))
    {
        $date_modif = $row[0];
    }
?>

    <p>La dernière modification de votre cursus à été faite le <?php echo $date_modif; ?></p>
    <table id="cursus">
        <tr>
            <td>catégorie d'ue</td>
            <td>TC de BR</td>
            <td>FIL</td>
            <td>TCBR+FIL</td>
            <td>Total</td>
        </tr>
        <tr>
            <td>CS</td>
            <td rowspan="2"><?php echo $credit_obtenu['R01']; ?>/<?php echo $array_credit_min['R01'] ?></td>
            <td rowspan="2"><?php echo $credit_obtenu['R02']; ?>/<?php echo $array_credit_min['R02'] ?></td>
            <td><?php echo $credit_obtenu['R03']; ?>/<?php echo $array_credit_min['R03'] ?></td>
            <td rowspan="2"><?php echo $credit_obtenu['R05']; ?>/<?php echo $array_credit_min['R05'] ?></td>
        </tr>
        <tr>
            <td>TM</td>
            <td><?php echo $credit_obtenu['R04']; ?>/<?php echo $array_credit_min['R04'] ?></td>
        </tr>
        <tr>
            <td>Stage</td>
            <td><?php echo $credit_obtenu['R06']; ?>/<?php echo $array_credit_min['R06'] ?></td>
            <td><?php echo $credit_obtenu['R07']; ?>/<?php echo $array_credit_min['R07'] ?></td>
            <td></td>
            <td><?php echo $credit_obtenu['R06'] + $credit_obtenu['R07']; ?>/<?php echo $array_credit_min['R06'] + $array_credit_min['R07']; ?></td>
        </tr>
        <tr>
            <td>EC</td>
            <td colspan="2"><?php echo $credit_obtenu['R08']; ?>/<?php echo $array_credit_min['R08'] ?></td>
            <td></td>
            <td><?php echo $credit_obtenu['R08']; ?>/<?php echo $array_credit_min['R08'] ?></td>
        </tr>
        <tr>
            <td>ME</td>
            <td colspan="2" rowspan="2"><?php echo $credit_obtenu['R11']; ?>/<?php echo $array_credit_min['R11'] ?></td>
            <td><?php echo $credit_obtenu['R09']; ?>/<?php echo $array_credit_min['R09'] ?></td>
            <td rowspan="2"><?php echo $credit_obtenu['R11']; ?>/<?php echo $array_credit_min['R11'] ?></td>

        </tr>
        <tr>
            <td>HT</td>
            <td><?php echo $credit_obtenu['R10']; ?>/<?php echo $array_credit_min['R10'] ?></td>
        </tr>
        <!--<tr>
            <td>HP</td>
            <td colspan="2"><?php //echo $credit_obtenu['R07']; ?>/8</td>
            <td></td>
            <td><?php //echo $credit_obtenu['R07']; ?>/8</td>
        </tr>-->
        <tr>
            <td>Total</td>
            <td colspan="3"></td>
            <td><?php echo $credit_obtenu['R15']; ?>/<?php echo $array_credit_min['R15'] ?></td>
        </tr>
        <tr>
            <td>NPML</td>
            <td colspan="4"><?php if($credit_obtenu['R14'] == 1){echo 'Validé <i class="fa fa-check" style="font-size:30px;color:green"></i>';} else {echo 'Non Validé <i class="fa fa-close" style="font-size:30px;color:red"></i>';} ?></td>
        </tr>
        <tr>
            <td>Semestre à l'étranger</td>
            <td colspan="4"><?php if($credit_obtenu['R13'] == 1){echo 'Validé <i class="fa fa-check" style="font-size:30px;color:green"></i>';} else {echo 'Non Validé <i class="fa fa-close" style="font-size:30px;color:red"></i>';} ?></td>
        </tr>
    </table>
    <br>
    <div>
        Ce qu'il vous reste à valider pour être diplomé :
        <ul>
            <?php
            //afficher ce qu'il reste à valider
            foreach($credit_obtenu as $key => $element) {
                validation($element, $array_credit_min[$key], $array_categorie[$key], $array_affectation[$key]);
            }
            ?>
        </ul>
        
    </div>