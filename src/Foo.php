<?php

/**
 * Classe test fonction foo (temps d'implémentation : 1h)
 * @author y92 (GitHub)
 */
final class Foo {

    /**
     * Class constructor
     */
    private function __construct() 
    {
    }

    /**
     * Compare deux intervalles représentés sous formes de tableaux de deux entiers (d'abord les minimums, puis les maximums)
     * @param I1 premier intervalle
     * @param I2 second intervalle
     * @return -1 si le premier intervalle est inférieur au second, 0 si les deux intervalles sont égaux, 1 si le premier intervalle est supérieur au second
     */
    private static function compareIntervals(array $I1, array $I2) : int
    {
        switch ($I1[0] <=> $I2[0]) {
            case 0:
                return $I1[1] <=> $I2[1];
            default:
                return $I1[0] <=> $I2[0];
        }
    }

    /**
     * Fusionne deux tableaux d'intervalles déjà triés
     * @param I1 premier tableau
     * @param I2 second tableau
     * @return res fusion des deux tableaux, également triée
     */
    private static function mergeSortedIntervalsArrays(array $I1, array $I2) : array
    {
        $res = []; // le tableau à renvoyer

        $c1 = 0; // curseur parcourant le 1er tableau
        $c2 = 0; // curseur parcourant le 2nd tableau

        $len1 = count($I1); // longueur du 1er tableau
        $len2 = count($I2); // longueur du 2nd tableau

        while (($c1 < $len1) && ($c2 < $len2)) {
            switch(self::compareIntervals($I1[$c1], $I2[$c2])) {
                case -1:
                    $res[] = $I1[$c1++];
                    break;
                default:
                    $res[] = $I2[$c2++];
                    break;
            }
        }

        for ($k = $c1; $k<$len1; $k++) {
            $res[] = $I1[$k];
        }

        for ($k = $c2; $k<$len2; $k++) {
            $res[] = $I2[$k];
        }

        return $res;
    }

    /**
     * Trie un tableau d'intervalles en ordre croissant
     * @param intervals le tableau à trier
     * @return le tableau trié
     */
    private static function sortIntervals(array $intervals) : array
    {
        $len = count($intervals);

        if ($len == 0) {
            return [];
        }

        if ($len == 1) {
            return [[$intervals[0][0], $intervals[0][1]]];
        }

        $left = [];
        $right = [];

        $middle = floor($len/2);

        for ($i=0; $i<$middle; $i++) {
            $left[] = [$intervals[$i][0], $intervals[$i][1]]; 
        }

        for ($i=$middle; $i<$len; $i++) {
            $right[] = [$intervals[$i][0], $intervals[$i][1]];
        }

        $left = self::sortIntervals($left);
        $right = self::sortIntervals($right);

        return self::mergeSortedIntervalsArrays($left, $right);
    }

    /**
     * Retourne une chaîne de caractères représentant un tableau d'intervalles
     * @param intervals le tableau à traiter
     * @return la chaîne correspondant au tableau
     */
    public static function makeString($intervals) : string
    {
        $tmp = [];
        foreach ($intervals as $elt) {
            $tmp[] = "[".implode(",", $elt)."]";
        }

        return "[".implode(", ",$tmp)."]";
    }

    /**
     * Prend en argument un tableau d'intervalles (représentés par des tableaux de deux entiers) et renvoie un nouveau tableau contenant toutes les réunions 
     * d'intervalles possibles. La fonction trie d'abord le tableau en entrée dans l'ordre croissant des minimums puis des maximums. La fonction parcourt ensuite 
     * le tableau trié et unit tous les intervalles qui se chevauchent.
     * @param intervals le tableau d'intervalle à traiter
     * @return tableau contenant toutes les unions d'intervalles possibles
     */ 
    public static function foo(array $intervals) : array
    {
        if (count($intervals) < 1) {
            return [];
        }

        $sortedIntervals = self::sortIntervals($intervals); // on trie le tableau passé en entrée
        $len = count($sortedIntervals); // longueur du tableau

        $res = []; // le tableau à renvoyer, initialement vide

        // on prend comme point de départ le premier intervalle du tableau
        $tmp1 = $sortedIntervals[0][0]; 
        $tmp2 = $sortedIntervals[0][1];

        for ($k=1; $k<$len; $k++) {
            // si deux intervalles consécutifs se chevauchent, on prend leur union
            if ($sortedIntervals[$k][0] <= $sortedIntervals[$k-1][1]) {
                $tmp2 = max($tmp2, $sortedIntervals[$k][1]);
            }
            // sinon, on ajoute l'intervalle (ou l'union) déjà obtenue précédemment et on prend comme point de repère le nouvel intervalle
            else {
                $res[] = [$tmp1, $tmp2];
                $tmp1 = $sortedIntervals[$k][0];
                $tmp2 = $sortedIntervals[$k][1];
            }

            // si on est à la fin du tableau, on ajoute l'intervalle (ou l'union) obtenue précédemment
            if ($k == ($len-1)) {
                $res[] = [$tmp1, $tmp2];
            }
        }

        return $res;
    }
}

?>