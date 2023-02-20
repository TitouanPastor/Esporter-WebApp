<?php
    function displayEquipePoule($idPoule,$libellePoule,$reqEquipePouleTrie){
        $clair = 0;
        echo '
            <button type ="submit" class="poule" name="submitPoule" value ='.$idPoule.'>
                <div class="pouleLibelle">
                    <span>'.$libellePoule.'</span>
                </div>
            ';
        while ($equipe = $reqEquipePouleTrie -> fetch()){
            $equipeNom = $equipe[0];
            $equipeNbMatchGagne = $equipe[1];
            if ($clair % 2 == 0) {
                echo '
                    <div class="equipe violet-fonce">
                        <span>' . $equipeNom . '</span>
                        <div>' . $equipeNbMatchGagne . ' </div>
                    </div>
                ';
            } else {
                    echo '
                    <div class="equipe violet-clair">
                        <span>' . $equipeNom . '</span>
                        <div>' . $equipeNbMatchGagne . ' </div>
                    </div>
                ';
            }
            $clair += 1;
        }
        echo '
            </button>
        ';
    }

    
?>