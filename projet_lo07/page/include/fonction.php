<?php 
    function input_form ($label, $type, $name) {
        echo "<label for=" . $name . " >" . $label . " : </label><br>";
        echo "<input type=" . $type . " name=" . $name . " /><br>";
    }

    function select_form ($label, $name, $hash) {
        echo "<label for=" . $name . " >" . $label . " : </label><br>";
        echo "<select name=" . $name . ">";
        foreach ($hash as $element) {
            echo "<option value=" . $element . ">" . $element . "</option><br>"; 
        }
        echo "</select><br>";
    }

    function option_select ($element) {
        echo "<option value=" . $element . ">" . $element . "</option><br>"; 
    }
    
    function input_datalist($tuple, $table, $name, $list, $type) {
        global $bdd;
        $resultat = mysqli_query($bdd, "SELECT distinct $tuple FROM $table ORDER BY $tuple");
        echo '
            <input list="' . $list . '" type="' . $type . '" name="' . $name . '">'; 
        echo '<datalist id="' . $list . '">';
        while($donnees = mysqli_fetch_assoc($resultat))
        {
            echo '<option value="' . $donnees[$tuple] . '">';
            echo "\n";
        }
        mysqli_free_result($resultat);
        echo '</datalist><br>';
    }

    function select_dba_regle($select) {
        if (mysqli_num_rows($select) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($select)) {
                echo $row['SUM(elem_formation.credit)'];
            }
        } else {
            echo "0";
        }
    }

    //fonction pour rechercher les credits obtenus selon chaques règles données dans un fichier csv
    function select_credit($n_etu, $method, $categorie, $affectation) {
        global $bdd;
        //tri selon le test (SUM, EXIST...)
        switch($method) {
            case 'SUM':
                //tri selon l'affectation différencier TCBR/FCBR/BR
                switch($affectation) {
                    case 'TCBR':
                        if(strlen($categorie) == 2) {
                            $var = mysqli_query($bdd, "SELECT $method(elem_formation.credit), cursus.n_etu FROM elem_formation, cursus WHERE n_etu='$n_etu' and elem_formation.id=cursus.id_elem_formation and affectation='$affectation' and categorie='$categorie' ");
                        }
                        else if(strlen($categorie) > 3 && ($categorie[0] . $categorie[1] != 'UT')) {
                            $categorie = explode('+', $categorie);
                            $var = mysqli_query($bdd, "SELECT $method(elem_formation.credit), cursus.n_etu FROM elem_formation, cursus WHERE n_etu='$n_etu' and elem_formation.id=cursus.id_elem_formation and affectation='$affectation' and categorie in ('$categorie[0]','$categorie[1]')");
                        } 
                        break;
                    case 'FCBR':
                         if(strlen($categorie) == 2) {
                            $var = mysqli_query($bdd, "SELECT $method(elem_formation.credit), cursus.n_etu FROM elem_formation, cursus WHERE n_etu='$n_etu' and elem_formation.id=cursus.id_elem_formation and affectation='$affectation' and categorie='$categorie' ");
                        }
                        else if(strlen($categorie) > 3 && ($categorie[0] . $categorie[1] != 'UT')) {
                            $categorie = explode('+', $categorie);
                            $var = mysqli_query($bdd, "SELECT $method(elem_formation.credit), cursus.n_etu FROM elem_formation, cursus WHERE n_etu='$n_etu' and elem_formation.id=cursus.id_elem_formation and affectation='$affectation' and categorie in ('$categorie[0]','$categorie[1]')");
                        }
                        break;
                    case 'BR':
                    case 'UTT':
                         if(strlen($categorie) == 2) {
                            $var = mysqli_query($bdd, "SELECT $method(elem_formation.credit), cursus.n_etu FROM elem_formation, cursus WHERE n_etu='$n_etu' and elem_formation.id=cursus.id_elem_formation and affectation in ('TCBR','FCBR','BR') and categorie='$categorie' ");
                        }
                        else if(strlen($categorie) > 3 && ($categorie[0] . $categorie[1] != 'UT')) {
                            $categorie = explode('+', $categorie);
                            $var = mysqli_query($bdd, "SELECT $method(elem_formation.credit), cursus.n_etu FROM elem_formation, cursus WHERE n_etu='$n_etu' and elem_formation.id=cursus.id_elem_formation and affectation in ('TCBR','FCBR','BR') and categorie in ('$categorie[0]','$categorie[1]')");
                        }
                        else if ($categorie[0] . $categorie[1] == 'UT') {
                            preg_match_all('([A-Z]+[A-Z])', $categorie, $cat);                    
                            $cat1 = $cat[0][1];
                            $cat2 = $cat[0][2];
                            $var = mysqli_query($bdd, "SELECT $method(elem_formation.credit), cursus.n_etu FROM elem_formation, cursus WHERE n_etu='$n_etu' and elem_formation.id=cursus.id_elem_formation and affectation in ('TCBR', 'FCBR','BR') and categorie in ('$cat1','$cat2') and utt='Y' ");
                        }
                        elseif($categorie = 'ALL') {
                            $var = mysqli_query($bdd, "SELECT $method(elem_formation.credit), cursus.n_etu FROM elem_formation, cursus WHERE n_etu='$n_etu' and elem_formation.id=cursus.id_elem_formation ");
                        }
                        break;
                }
                //stocker les valeurs de la requête dans un tableau credit_obtenu
                while ($row = mysqli_fetch_row($var))
                {
                    if($row[0] != null) {
                        $credit_obtenu = $row[0];
                    } else {$credit_obtenu = 0;}
                }
                break;
            case 'EXIST':
                $query = mysqli_query($bdd, "SELECT elem_formation.categorie, cursus.n_etu FROM elem_formation, cursus WHERE n_etu='$n_etu' and elem_formation.id=cursus.id_elem_formation and categorie='$categorie' ");
                if(mysqli_num_rows($query) > 0) {
                    $credit_obtenu = 1;
                } else {$credit_obtenu = 0;}
                break;
            default:
                echo 'error';
        }
        return $credit_obtenu;
    }

    //calcul pour vérifier ce qu'il reste à valider
    function validation($obtenu, $min, $categorie, $affectation) {
        $resultat = $obtenu - $min;
        if($resultat < 0) {
            echo '<li>';
            echo abs($resultat)." credits ".$categorie." en ".$affectation;
            echo '</li>';
        }
    }

?> 