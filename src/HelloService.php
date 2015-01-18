<?php

/**
 * @file
 * Contains Drupal\hello\HelloService.
 *
 */

namespace Drupal\hello;

class HelloService {

  protected $hello_value;

  public function __construct() {
    $this->hello_value = 'Sid Vicious';
  }

  public function getHelloValue() {
    return $this->hello_value;
  }
}