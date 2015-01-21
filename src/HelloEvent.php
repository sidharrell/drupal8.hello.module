<?php

/**
 * @file
 * Contains Drupal\hello\HelloEvent.
 */

namespace Drupal\hello;

use Symfony\Component\EventDispatcher\Event;
use Drupal\Core\Config\Config;

class HelloEvent extends Event {

  protected $config;

  /**
   * Constructor.
   *
   * @param Config $config;
   */
  public function __construct(Config $config) {

    $this->config = $config;

  }

  public function getConfig() {
    return $this->config;
  }

  public function setConfig($config) {
    $this->config = $config;
  }

}