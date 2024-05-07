<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;

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

}
