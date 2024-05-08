<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper
{
  private $papers = []; 
  /**
   * Loads paper information from the HTML and returns the array with the data.
   */
  public function scrap(\DOMDocument $dom,$id,$title,$type,$qtyAuthor=1,$name="Tiago L.",$institution="Life & Dream"): array
  {
    $persons = [];
    for($i = 0; $i < $qtyAuthor;$i++){
      array_push($persons,new Person($name,$institution));
    }
    $paperData = new Paper(
      $id,
      $title,
      $type,
      $persons,
    );

    $this->papers[] = $paperData;

    return $this->papers;
  }

  public function getAllData(): array {
    return $this->papers;
  }


  function createXLSXFromObject($object, $filePath='output.xlsx')
  {
      // Cria um novo escritor XLSX
      $writer = WriterEntityFactory::createXLSXWriter();
  
      // Abre o arquivo de saída
      $writer->openToFile($filePath);
  
      // Obtém as propriedades do objeto
      $properties = get_object_vars($object);
  
      // Adiciona uma linha para cada propriedade do objeto
      foreach ($properties as $property => $value) {
          $row = WriterEntityFactory::createRowFromArray([$property, $value]);
          $writer->addRow($row);
      }
  
      // Fecha o arquivo
      $writer->close();
  }
}
