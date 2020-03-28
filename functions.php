<?php

/**
 * funzione PHP tradotta dall'originale CalcolaPagina in JS
 */
function calcolaPagina($input_string) {

    $characters = str_split($input_string);
    $decodificata="";

    $tab_caratteri="0123456789abcdefghijklmnopqrstuvwxyz._~ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    foreach ($characters as $character) {
        $new_character = strpos($tab_caratteri,$character)^19;

        $decodificata .= substr($tab_caratteri,$new_character,1);
    }

    return $decodificata;
}

function url_exists($url) {
    $file_headers = @get_headers($url);

    if ($file_headers && strpos( $file_headers[0], '200')) {
        return true;
    } else {
        return false;
    }
}

function create_possible_arrays(&$set, &$results)
{
    for ($i = 0; $i < count($set); $i++)
    {
        $results[] = $set[$i];
        $tempset = $set;
        array_splice($tempset, $i, 1);
        $tempresults = array();
        create_possible_arrays($tempset, $tempresults);
        foreach ($tempresults as $res)
        {
            $results[] = $set[$i] . $res;
        }
    }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz._~ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function createEncodedDic() {

    global $array;

    $file = fopen("dizionari/brute-thc-encoded.txt", "w");

    foreach ($array as $word) {
        $encodedWord = calcolaPagina($word)."\n";
        fwrite($file,$encodedWord);
    }

    fclose($file);

}