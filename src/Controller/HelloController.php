<?php

namespace Drupal\hello\Controller;

class HelloController {
  public function content() {
    return array(
        '#type' => 'markup',
        '#markup' => t('Hello.'),
    );
  }
}