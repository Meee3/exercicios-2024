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

    //puxar o total
    $qtd = count($xpath->query("//div[@class='volume-info']"));
    $id = $xpath->query("//div[@class='volume-info']");
    $title = $xpath->query("//h4[@class='my-xs paper-title']");
    $type = $xpath->query("//div[@class='tags mr-sm']");


    //Autores

    // Seleciona todas as divs com a classe "authors"
    $divs = $xpath->query("//div[@class='authors']");
    $qtdAuthors = [];
    $authors = [];

    foreach ($divs as $div) {
      // Obtém todos os spans dentro da div
      $spans = $div->getElementsByTagName('span');

      $authors = [];
      foreach ($spans as $span) {
        $name = $span->nodeValue; // Obtém o nome do autor
        $institution = $span->getAttribute('title'); // Obtém a instituição do autor

        // Adiciona o autor ao array
        $authors[] = [
          'name' => $name,
          'institution' => $institution
        ];
      }
      //$qtdAuthors = count($authors);
      array_push($qtdAuthors,count($authors));
    }


    print_r($type->item(0)->nodeValue);
    print_r($authors);
    exit;

    for ($i = 0; $i < $qtd; $i++) {
      $instancia->scrap(
        $dom,
        $id->item($i)->nodeValue,
        $title->item($i)->nodeValue,
        $type->item($i)->nodeValue,
        $qtyAuthor = $qtdAuthors[$i],
        $name = $authors[$i]['name'],
        $institution = $authors[$i]['institution']

      );
    }



    $instancia->scrap($dom, 15, "Meu Valor", "Future", 10);

    // Write your logic to save the output file below.
    print_r($instancia->getAllData());
  }

}
