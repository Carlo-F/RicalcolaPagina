<?php

/**
 * RicalcolaPagina
 * 
 * A single-class PHP library to bypass old CalcolaPagina.js 'hiding system'.
 * 
 */
namespace carloF;

class RicalcolaPagina {

    protected $dictionaryArray = [];

    protected $website_base_url = "http://localhost/";

    protected $pageExtension = '.html';

    public function __construct($dictionaryName, $websiteUrl, $pageExtension)
    {
        $this->dictionaryArray = $this->setDictionaryArray($dictionaryName);
        $this->website_base_url = $websiteUrl;
        $this->pageExtension = $pageExtension;
    }

    private function setDictionaryArray($dictionaryName) {

        $dictionaryArray = [];
        $dictionaryname = "dizionari/$dictionaryName";
        $file = fopen("dizionari/$dictionaryName", "r");
        $randomStrings = fread($file, filesize($dictionaryname));
        $dictionaryArray = preg_split('/\r\n|\r|\n/',$randomStrings);
        fclose($file);

        return $dictionaryArray;
    }
    
    public function ricalcola() {
    
        foreach ($this->dictionaryArray as $word) {
            echo "sto provando: $word<br>";
                $url = $this->website_base_url.$word.$this->pageExtension;
        
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
        
        }
    }

    public function getPageExtension() {
        echo $this->pageExtension;
    }

    public function getDictionaryArray() {
        print_r($this->dictionaryArray);
    }
}