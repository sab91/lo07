<?php 
    function input_form ($label, $type, $name) {
        echo "<label for=" . $name . " >" . $label . " : </label><br>";
        echo "<input type=" . $type . " name=" . $name . " /><br>";
    }

    function input_form_pre ($label, $type, $name, $value) {
        echo "<label for=" . $name . " >" . $label . " : </label><br>";
        echo "<input type=" . $type . " name=" . $name . " value='" . $value .  "' /><br>";
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

    function select_data_dba ($tuple, $table, $branche, $name) {
        global $bdd;
        $reponse = $bdd->query("SELECT " . $tuple . " FROM " . $table . " where branche='" . $branche . "'");
        echo "<select name=" . $name . " >";
        while ($donnees = $reponse->fetch()) {
            option_select($donnees[$tuple]);
        }
        echo "</select><br>";
        $reponse->closeCursor();
    }

    function tr($id, $name_row, $branche) {
        echo "<tr id='" . $id . "'>";
        echo '<td>' . $name_row . '</td>';
        $nb=1;
        for($nb=1;$nb<7;$nb++) {
            echo '<td>';
            select_data_dba("sigle", "ue", $branche, "ue" . $nb . $id);
            echo '</td>';
        }
        echo "</tr>";
    } 

    function import_csv($file) {
        $file = fopen("contacts.csv","r");
        print_r(fgetcsv($file));
        fclose($file);
    }
?> 