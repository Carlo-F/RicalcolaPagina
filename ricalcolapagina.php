<?php

$opts = getopt("u:e:d:h::");

if(isset($opts["u"]) && isset($opts["e"]) && isset($opts["d"])){
    $baseUrl = $opts["u"];
    $pageExtension = $opts["e"];
    $dictionaryPath = $opts["d"];

} elseif(isset($opts["h"])) {
    print("RicalcolaPagina\ntrova le pagine nascoste col vecchio script 'CalcolaPagina.js'\nParametri richiesti:\n-u : l'url base dove cercare\n-e : estensione della pagina da cercare\n-d : dizionario da utilizzare");
    exit;  
} else {
    print("Errore: parametri mancanti. 'u'[Url base], 'e'[estensione pagina], 'd'[Dizionario] \nEsempio: php ricalcolapagina.php -u http://localhost/test/ -e .html -d dizionari/dizionario.txt");
    exit;
}
        
$dictionary = [];
$file = fopen("$dictionaryPath", "r");
$randomStrings = fread($file, filesize($dictionaryPath));
$dictionary = preg_split('/\r\n|\r|\n/',$randomStrings);
fclose($file);

$starttime = microtime(true);
echo "[" . date("H:i:s") . "] Ricerca iniziata..\n";

foreach ($dictionary as $word) {
    echo "sto provando: $word.$pageExtension\n";
    $url = $baseUrl.$word.$pageExtension;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $retCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($retCode == 200) {
        $endtime = microtime(true);
        $timediff = $endtime - $starttime;
        echo "[" . date("H:i:s") . "] La pagina esiste: $url\n";
        echo "tempo impiegato $timediff secondi";
        return true;
    } else {
       continue;
    }

}

die("[" . date("H:i:s") . "]pagina non trovata. provare un\'altro dizionario?");
