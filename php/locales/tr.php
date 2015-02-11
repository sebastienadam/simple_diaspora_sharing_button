<?php

/**
 * Description of tr
 *
 * @author Sébastien
 */
class Tr {
  private $validLanguages = array("en","eo","fr");
  private $defaultLanguage = "en";
  private $lang;

  public function __construct() {
    $this->setCurrentLanguageFromHttp();
  }
  
  private function setCurrentLanguageFromHttp() {
    $httpAcceptedLanguages = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
    $acceptedLanguages = array();
    foreach ($httpAcceptedLanguages as $httpAcceptedLanguage) {
      $acceptedLanguages[] = strtolower(substr($httpAcceptedLanguage,0,2));
    }
    $found = false;
    foreach($acceptedLanguages as $acceptedLanguage) {
      if(in_array($acceptedLanguage, $this->validLanguages)) {
        $this->setLanguage($acceptedLanguage);
        $found = true;
        break;
      }
    }
    if (!$found) {
      $this->setLanguage($this->defaultLanguage);
    }
  }
  
  public function setLanguage($lang) {
    $langFileName = dirname(__FILE__).DIRECTORY_SEPARATOR."lang.$lang.php";
    if(file_exists($langFileName)) {
      include $langFileName;
      $this->lang = $tr;
    } else {
      throw new Exception('Invalid language!');
    }
  }
  
  public function message($token) {
    return isset($this->lang[$token])?$this->lang[$token]:$token;
  }
}
