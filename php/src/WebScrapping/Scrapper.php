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
  public function scrap(\DOMDocument $dom, $id): array
  {
    // Simulação de raspagem de dados para um único artigo
    $paperData = new Paper(
      $id,
      'The Nobel Prize in Physiology or Medicine 2023',
      'Nobel Prize',
      [
        new Person('Katalin Karikó', 'Szeged University'),
        new Person('Drew Weissman', 'University of Pennsylvania')
      ]
    );

    $this->papers[] = $paperData;

    return $this->papers;
  }

  public function getAllData(): array {
    return $this->papers;
  }

}
