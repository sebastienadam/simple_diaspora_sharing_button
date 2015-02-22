<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Sébastien Adam http://www.sebastienadam.be/
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

/**
 * Translation class. By default, the language is selected from the browser
 * parameters.
 *
 * @author Sébastien
 */
class Tr {
  private $validLanguages = array("en","fr");
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
