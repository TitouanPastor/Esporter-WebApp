<?php
    
    session_start();
    require_once(realpath(dirname(__FILE__) . '/../visiteur/header-controller.php'));
    require_once(realpath(dirname(__FILE__) . '/../../model/Tournoi.php'));
    
    $tournoi = new Tournoi();
    $checkValider = 0;

    //Exécution de la requête en fonction des paramètres fournis (liste rempli ou non)
    if (isset($_POST["valider"])) {
        if ($_POST['equipe_jeu'] != "default") {
            $checkValider = 1;
            $req = $tournoi->getClassementCM($_POST["equipe_jeu"]);
        }
    }

    //Valeur et affichage d'une liste -> conserver la valeur après validation
    if (isset($_POST["equipe_jeu"])) {
        $valueEquipeJeu = $_POST["equipe_jeu"];
    } else {
        $valueEquipeJeu = "default";
    }

    $affichageJeux = "";

    //Affichage de la liste des jeux
    $jeu = $tournoi->getJeux();
    while ($donnees = $jeu->fetch()) {
        $affichageJeux .= '<option value='.$donnees['Id_Jeu']; 
        if ($valueEquipeJeu == $donnees['Id_Jeu']) {
            $affichageJeux .= ' selected';
        }
        $affichageJeux .= '>';
        $affichageJeux .= $donnees['Libelle'];
        $affichageJeux .= '</option>';
     } 

     $affichageTableau = "";

    //Affichage du classement
    if ($checkValider == 1) {
        if ($req->rowCount() == 0) {
            $affichageTableau .= "<div style='display : flex; justify-content :center; padding-top : 50px;'> Il n'y a pas de tournoi pour ces critères </div>";
        } else {
            $affichageTableau .= "
        <div class = 'tableau-style'>
        <table>
            <thead>
                <tr>
                    <th> Place </th>
                    <th> Nom de l'Équipe </th>
                    <th> Nombre de Points</th>
                </tr>
            </thead>

            <tbody>";
            $i = 0;
            while ($donnees = $req->fetch()) {
                $i++;
                $affichageTableau .= '
                <tr>';

                //Place
                if ($i == 1) {
                    $affichageTableau .= '<td><svg width="50px" height="50px" viewBox="-3.5 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.73795 18.8436L12.9511 20.6987L6.42625 32L4.55349 27.8233L9.73795 18.8436Z" fill="#CE4444"/>
                        <path d="M9.73795 18.8436L6.52483 16.9885L0 28.2898L4.55349 27.8233L9.73795 18.8436Z" fill="#983535"/>
                        <path d="M14.322 18.8436L11.1088 20.6987L17.6337 32L19.5064 27.8233L14.322 18.8436Z" fill="#983535"/>
                        <path d="M14.322 18.8436L17.5351 16.9885L24.0599 28.2898L19.5064 27.8233L14.322 18.8436Z" fill="#CE4444"/>
                        <path d="M22.9936 11.0622C22.9936 17.1716 18.0409 22.1243 11.9314 22.1243C5.82194 22.1243 0.869249 17.1716 0.869249 11.0622C0.869249 4.9527 5.82194 0 11.9314 0C18.0409 0 22.9936 4.9527 22.9936 11.0622Z" fill="url(#paint0_linear_103_1801)"/>
                        <path d="M20.5665 11.0621C20.5665 15.8311 16.7004 19.6972 11.9315 19.6972C7.16247 19.6972 3.29645 15.8311 3.29645 11.0621C3.29645 6.29315 7.16247 2.42713 11.9315 2.42713C16.7004 2.42713 20.5665 6.29315 20.5665 11.0621Z" fill="#A88300"/>
                        <path d="M21.0477 11.984C21.0477 16.7641 17.1727 20.6391 12.3926 20.6391C7.61251 20.6391 3.73748 16.7641 3.73748 11.984C3.73748 7.20389 7.61251 3.32887 12.3926 3.32887C17.1727 3.32887 21.0477 7.20389 21.0477 11.984Z" fill="#C28B37"/>
                        <path d="M20.5868 11.0621C20.5868 15.8422 16.7118 19.7172 11.9317 19.7172C7.15159 19.7172 3.27656 15.8422 3.27656 11.0621C3.27656 6.28205 7.15159 2.40702 11.9317 2.40702C16.7118 2.40702 20.5868 6.28205 20.5868 11.0621Z" fill="#C09525"/>
                        <path d="M11.9781 5.04096L13.8451 8.77502L17.5792 9.24178L15.0151 12.117L15.7122 16.2431L11.9781 14.3761L8.24404 16.2431L8.94729 12.117L6.37701 9.24178L10.1111 8.77502L11.9781 5.04096Z" fill="url(#paint1_linear_103_1801)"/>
                        <defs>
                        <linearGradient id="paint0_linear_103_1801" x1="11.1804" y1="4.03192" x2="12.6813" y2="31.965" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#FFC600"/>
                        <stop offset="1" stop-color="#FFDE69"/>
                        </linearGradient>
                        <linearGradient id="paint1_linear_103_1801" x1="11.9783" y1="5.04096" x2="11.9783" y2="16.2431" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#FFFCDD"/>
                        <stop offset="1" stop-color="#FFE896"/>
                        </linearGradient>
                        </defs>
                        </svg></td>';
                } elseif ($i == 2) {
                    $affichageTableau .= '<td><svg width="40px" height="40px" viewBox="-3.5 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.73779 18.8436L12.9509 20.6987L6.42609 32.0001L4.55333 27.8234L9.73779 18.8436Z" fill="#418ED6"/>
                        <path d="M9.73779 18.8436L6.52467 16.9885L-0.000155079 28.2899L4.55333 27.8234L9.73779 18.8436Z" fill="#2B63A6"/>
                        <path d="M14.3218 18.8436L11.1087 20.6987L17.6335 32.0001L19.5062 27.8234L14.3218 18.8436Z" fill="#2B63A6"/>
                        <path d="M14.3218 18.8436L17.5349 16.9885L24.0597 28.2899L19.5062 27.8234L14.3218 18.8436Z" fill="#418ED6"/>
                        <circle cx="12.0246" cy="11.0622" r="11.0622" fill="#E3E3E3"/>
                        <circle cx="12.0247" cy="11.0621" r="8.63501" fill="#595959"/>
                        <mask id="mask0_103_1231" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="3" y="3" width="19" height="18">
                        <circle cx="12.4857" cy="11.984" r="8.65511" fill="#C28B37"/>
                        </mask>
                        <g mask="url(#mask0_103_1231)">
                        <circle cx="12.0247" cy="11.0622" r="8.65511" fill="url(#paint0_linear_103_1231)"/>
                        </g>
                        <path d="M12.0713 5.04102L13.9383 8.77508L17.6724 9.24183L15.1083 12.1171L15.8054 16.2432L12.0713 14.3762L8.33724 16.2432L9.04049 12.1171L6.47021 9.24183L10.2043 8.77508L12.0713 5.04102Z" fill="url(#paint1_linear_103_1231)"/>
                        <defs>
                        <linearGradient id="paint0_linear_103_1231" x1="12.0247" y1="2.4071" x2="12.0247" y2="19.7173" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#9CA1A3"/>
                        <stop offset="1" stop-color="#9CA1A3" stop-opacity="0"/>
                        </linearGradient>
                        <linearGradient id="paint1_linear_103_1231" x1="12.0713" y1="5.04102" x2="12.0713" y2="16.2432" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#F1F5F5"/>
                        <stop offset="0.0001" stop-color="white"/>
                        <stop offset="1" stop-color="#F1F5F5"/>
                        </linearGradient>
                        </defs>
                        </svg></td>';
                } elseif ($i == 3) {
                    $affichageTableau .= '<td><svg width="30px" height="30px" viewBox="-3.5 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.73779 18.8436L12.9509 20.6987L6.42609 32.0001L4.55333 27.8234L9.73779 18.8436Z" fill="#AA75CB"/>
                        <path d="M9.73779 18.8436L6.52467 16.9885L-0.000155079 28.2899L4.55333 27.8234L9.73779 18.8436Z" fill="#73488D"/>
                        <path d="M14.3218 18.8436L11.1087 20.6987L17.6335 32.0001L19.5062 27.8234L14.3218 18.8436Z" fill="#73488D"/>
                        <path d="M14.3218 18.8436L17.5349 16.9885L24.0597 28.2899L19.5062 27.8234L14.3218 18.8436Z" fill="#AA75CB"/>
                        <circle cx="12.0246" cy="11.0622" r="11.0622" fill="#DC9E42"/>
                        <circle cx="12.0247" cy="11.0621" r="8.63501" fill="#734C12"/>
                        <mask id="mask0_103_1242" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="3" y="3" width="19" height="18">
                        <circle cx="12.4857" cy="11.984" r="8.65511" fill="#C28B37"/>
                        </mask>
                        <g mask="url(#mask0_103_1242)">
                        <circle cx="12.0247" cy="11.0622" r="8.65511" fill="#A36D1D"/>
                        </g>
                        <path d="M12.0713 5.04102L13.9383 8.77508L17.6724 9.24183L15.1083 12.1171L15.8054 16.2432L12.0713 14.3762L8.33724 16.2432L9.04049 12.1171L6.47021 9.24183L10.2043 8.77508L12.0713 5.04102Z" fill="url(#paint0_linear_103_1242)"/>
                        <defs>
                        <linearGradient id="paint0_linear_103_1242" x1="12.0713" y1="5.04102" x2="12.0713" y2="16.2432" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#FCFF80"/>
                        <stop offset="0.401042" stop-color="#FDE870"/>
                        <stop offset="1" stop-color="#FFC759"/>
                        </linearGradient>
                        </defs>
                        </svg></td>';
                } else {
                    $affichageTableau .= '<td>' . $i . '</td>';
                }

                //Nom équipe
                if ($i == 1) {
                    $affichageTableau .= '<td style="font-size: 30px; font-weight: bold; color: #c09525;">' . $donnees[0] . '</td>';
                } elseif ($i == 2) {
                    $affichageTableau .= '<td style="font-size: 25px; font-weight: bold; color: #898d8f;">' . $donnees[0] . '</td>';
                } elseif ($i == 3) {
                    $affichageTableau .= '<td style="font-size: 21px; font-weight: bold; color: #a36d1d;">' . $donnees[0] . '</td>';
                } else {
                    $affichageTableau .= '<td>' . $donnees[0] . '</td>';
                }

                //Nombre de points
                if ($i == 1) {
                    $affichageTableau .= '<td style="font-size: 30px; font-weight: bold; color: #c09525;">' . $donnees[1] . '</td>';
                } elseif ($i == 2) {
                    $affichageTableau .= '<td style="font-size: 25px; font-weight: bold; color: #898d8f;">' . $donnees[1] . '</td>';
                } elseif ($i == 3) {
                    $affichageTableau .= '<td style="font-size: 21px; font-weight: bold; color: #a36d1d;">' . $donnees[1] . '</td>';
                } else {
                    $affichageTableau .= '<td>' . $donnees[1] . '</td>';
                }

                $affichageTableau .= '</tr>';
            }
            $affichageTableau .= "
                </tbody>
                </table>
                </div>";
        }
    }

    ob_start();
    require_once(realpath(dirname(__FILE__) . '/../../view/visiteur/classementCM-view.html'));
    $buffer = ob_get_clean();
    $buffer = str_replace("##AfficherJeux##", $affichageJeux, $buffer);
    $buffer = str_replace("##AffichageTableau##", $affichageTableau, $buffer);
    echo $buffer;
?>