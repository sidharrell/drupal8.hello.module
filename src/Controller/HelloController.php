<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloController.
 *
 */
namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * HelloController
 *
 */
class HelloController extends ControllerBase {

  protected $helloService;

  public function __construct($helloService) {
    $this->helloService = $helloService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
        $container->get('hello.hello_service')
    );
  }


  /**
   * Generates an example page.
   * @return multitype:string The content.
   */
  public function content() {
    return array(
        '#type' => 'markup',
        '#markup' => t('Hello @value!', array('@value' => $this->helloService->getHelloValue())),
    );
  }
}