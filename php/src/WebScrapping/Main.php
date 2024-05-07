<?php

namespace Chuva\Php\WebScrapping;
use DOMXPath;

/**
 * Runner for the Webscrapping exercise.
 */
class Main
{

  /**
   * Main runner, instantiates a Scrapper and runs.
   */
  public static function run(): void
  {
    // Salvando o estado atual de erros
    $previousSetting = libxml_use_internal_errors(true);

    $dom = new \DOMDocument('1.0', 'utf-8');
    $dom->loadHTMLFile(__DIR__ . '/../../assets/origin.html');
    $xpath = new DOMXPath($dom);

    // Restaurando o estado anterior de erros
    libxml_use_internal_errors($previousSetting);
    $instancia = new Scrapper();
    $data = $instancia->scrap($dom,"1");
    $data = $instancia->scrap($dom,"2");

    //puxar o total
    $teste = count($xpath->query("//div[@class='volume-info']"));
    echo $teste;
    exit;
    foreach ($teste as $div) {
      echo $div->nodeValue; // Isso irá imprimir o conteúdo de cada div com a classe "volume-info"
  }




    // Write your logic to save the output file below.
    print_r($instancia->getAllData());
  }

}
