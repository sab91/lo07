<form action="cursus.php" method="post" enctype="multipart/form-data">
    <div class=info_perso_etu>
        <h1>Informations étudiant</h1>
        <p>
            <?php
            $fichier = fopen("C:/wamp64/www/projet_lo07/csv/" . $_FILES['cursus']['name'],"r");

            while(! feof($fichier))
              {
                /*foreach($array as $element) {
                    $data = explode(";", $element);
                }*/
                /*print_r(fgets($fichier));*/
                $data = explode(";", fgets($fichier));
                print_r($data);
              }

            fclose($fichier);
            
            input_form('Nom', 'text', 'nom');
            input_form('Prénom', 'text', 'prenom');
            input_form('N° étu', 'number', 'n_etu');
            ?>
        </p>
        <div>
            <!--<label for="admission" >Etudiant admis en : </label><br>
            TC <input type="radio" name="admission" value="TC" onclick="afficher('visible');" ><br>
            Branche <input type="radio" name="admission" value="Branche" onclick="afficher('hidden');" ><br>--><label for="admission" >Etudiant admis en : </label><br>
            TC <input type="radio" name="admission" value="TC" id="tc" ><br>
            TC5 <input type="checkbox" name="tc_plus" value="TC5" >
            TC6 <input type="checkbox" name="tc_plus" value="TC6" ><br>
            Branche <input type="radio" name="admission" value="Branche" id="branche" checked><br>
            <label for="niveau_actuel">Niveau actuel : </label>
            <select name="niveau_actuel">
                <option value="tc1">TC1</option>
            </select>
        </div>
        <table>
            <tr>
                <td></td>
                <td>UE 1</td>
                <td>UE 2</td>
                <td>UE 3</td>
                <td>UE 4</td>
                <td>UE 5</td>
                <td>UE 6</td>
            </tr>
            <?php tr('tc1','TC1', 'TC') ?>
            <?php tr('tc2','TC2', 'TC') ?>
            <?php tr('tc3','TC3', 'TC') ?>
            <?php tr('tc4','TC4', 'TC') ?>
            <?php tr('tc5','TC5', 'TC') ?>
            <?php tr('tc6','TC6', 'TC') ?>
            <?php tr('br1','BR1', 'ISI') ?>
            <?php tr('br2','BR2', 'ISI') ?>
            <?php tr('br3','BR3', 'ISI') ?>
            <?php tr('br4','BR4', 'ISI') ?>

        </table>

    </div>
    <input type="submit" value="Envoyer">
</form>