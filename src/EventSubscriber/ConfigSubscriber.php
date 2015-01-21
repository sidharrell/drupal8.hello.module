<?php

/**
 * @file
 * Contains Drupal\hello\EventSubscriber\ConfigSubscriber
 */

namespace Drupal\hello\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConfigSubscriber implements EventSubscriberInterface {

  static function getSubscribedEvents() {
    $events['hello_form.save'][] = array('onConfigSave', 0);
    return $events;
  }

  public function onConfigSave($event) {

    $config = $event->getConfig();

    $name_website = $config->get('my_name') . " / " . $config->get('my_website');
    $config->set('my_name_website', $name_website);

  }

}