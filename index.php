<?php
set_time_limit(0);
//$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
$website_base_url = 'http://localhost/test/calcolaPagina/'; // da impostare manualmente url base del sito

$dictionaryname = "dizionari/brute-thc.txt";
$file = fopen("dizionari/brute-thc.txt", "r");
$randomStrings = fread($file, filesize($dictionaryname)); // da costruire con dizionari o regEx
$array = preg_split('/\r\n|\r|\n/',$randomStrings);
fclose($file);

$pageExtension = ".html"; // da impostare manualmente in base al sito

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

// $results = array();
// $str = 'aaobbi'; //your string
// $str = str_split($str); //converted to array
// create_possible_arrays($str, $results);
// //var_dump($results); //displaying all results
// //die;

function bruteAttack() {

    global $array, $website_base_url, $pageExtension;

    foreach ($array as $word) {

        if(strlen($word) > 4 && strlen($word) < 9 ) { // ipotesi: scartare stringhe con 4 caratteri o meno, scartare stringhe con 9 caratteri o piu'
            $url = $website_base_url.$word.$pageExtension;
    
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_exec($ch);
            $retCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        
            if($retCode == 200) {
                echo "La pagina esiste, si trova a <a href='$url'>$url</a><br>";
                return true;
            } else {
               continue;
            }
        } else {
            continue;
        }
    
    }
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
