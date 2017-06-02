<form action="cursus.php" method="post" enctype="multipart/form-data">
    <div class=info_perso_etu>
        <h1>Informations étudiant</h1>
        <p>
            <?php
            $fichier = fopen("C:/wamp64/www/projet_lo07/csv/" . $_FILES['cursus']['name'],"r"); 
            $c = 0; 
            $data = fread($fichier, filesize("C:/wamp64/www/projet_lo07/csv/" . $_FILES['cursus']['name']));
            $lines = explode("\n", $data);
            /*$lines = fgetcsv($fichier,"","\n");*/
            /*while(! feof($fichier) && $c <= 4)
            {
                $lines[] = fgetcsv($fichier,"","\n");
                $c++;
            }*/
            foreach($lines as $key => $data) {
                if($key <= 4) {list($class[],$value[]) = explode(';', $data);}
            }
            fclose($fichier);            
            print_r($lines);
            echo '<br>';
            print_r($class);
            echo '<br>';
            print_r($value);
            
            echo '<br>';
            
            input_form('Nom', 'text', 'nom');
            input_form('Prénom', 'text', 'prenom');
            input_form('N° étu', 'number', 'n_etu');
            ?>
        </p>
        <div>
            <label for="admission" >Etudiant admis en : </label><br>
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
           
        </table>

    </div>
    <input type="submit" value="Envoyer">
</form>