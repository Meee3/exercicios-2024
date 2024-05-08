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
    $titulo = $xpath->query("//h4[@class='my-xs paper-title']");
    $type = $xpath->query("//div[@class='tags mr-sm']");


    //Autores

    // Seleciona todas as divs com a classe "authors"
    $divsAuthors = $xpath->query("//div[@class='authors']");
    $divsInstitution = $xpath->query("//div[@class='authors']/span[@title]");
    $total_span = $xpath->evaluate("count(//div[@class='authors']/span)");

    $authors = [];
    $separaAuthors = [];
    $separaInstitution = [];
    $institution = [];
    $qtdAuthors = [];

    #Quantidade de Autores
    $divs = $xpath->query("//div[@class='authors']");
    foreach ($divs as $div) {
      $total_span = 0;
      $spans = $div->getElementsByTagName('span');
      foreach ($spans as $span) {
        $total_span++;
      }
      #echo "Total de spans dentro da div authors: " . $total_span;
      $qtdAuthors[] = $total_span;

    }

    foreach ($divsAuthors as $fxauthors) {

      $authors[] = $fxauthors->nodeValue;
      $separaAuthors[] = explode(';', $fxauthors->nodeValue);

    }

    $autores = [];
    foreach ($separaAuthors as $index => $nomes) {
      foreach ($nomes as $nome) {
        if (!empty(trim($nome))) {
          $autores[] = $nome;
        }
      }
    }


    foreach ($divsInstitution as $span) {
      $title = $span->getAttribute('title');
      if (!empty(trim($title))) {
        $institution[] = $title;
      }
    }


    $authorsfished = [];

    for ($i = 0; $i < count($autores) || $i < count($institution); $i++) {
      $name = isset($autores[$i]) ? trim($autores[$i]) : '';
      $institution_name = isset($institution[$i]) ? trim($institution[$i]) : '';

      if (!empty($name)) {
        $obj = ['name' => $name, 'institution' => $institution_name];
        $authorsfished[] = $obj;
      }
    }
    // print_r($authorsfished);
    //  print_r($qtdAuthors);
    //  exit;

    //Agrupar em cada bloco
    $grupos = [];
    foreach ($qtdAuthors as $chave => $valor) {
      $grupo = [];
      for ($i = 0; $i < $valor; $i++) {
         $grupo = $authorsfished[$i];
          // $grupo['name'] = "Oi";
          // $grupo["institution " . ($i + 1)] = "Oi";

      }
      $grupos[$chave] = $grupo;
  }


  for($i = 0;$i < 62; $i++) {
    $instancia->scrap(
        $dom,
        $id->item($i)->nodeValue,
        $titulo->item($i)->nodeValue,
        $type->item($i)->nodeValue,
        $qtdAuthors[$i],
        $grupos[$i]['name'],
        $grupos[$i]['institution']
    );
}



    #$instancia->scrap($dom, 15, "Meu Valor", "Future", 10);

    // Write your logic to save the output file below.
    print_r($instancia->getAllData());

   $instancia->createXLSXFromObject($instancia);
  }

}
