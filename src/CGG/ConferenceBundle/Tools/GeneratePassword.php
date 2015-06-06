<?php
namespace CGG\ConferenceBundle\Tools;


class GeneratePassword {

    function genererMDP (){
        $longueur = 8;
        $mdp = "";

        $possible = "12346789abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ";

        $longueurMax = strlen($possible);

        if ($longueur > $longueurMax) {
            $longueur = $longueurMax;
        }
        $i = 0;
        while ($i < $longueur) {
            $caractere = substr($possible, mt_rand(0, $longueurMax-1), 1);

            if (!strstr($mdp, $caractere)) {
                $mdp .= $caractere;
                $i++;
            }
        }

        return $mdp;
    }
}