<?php

/**
 * @file
 * Contains \Drupal\hello\Form\HelloForm.
 */
namespace Drupal\hello\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\hello\HelloEvent;

class HelloForm extends ConfigFormBase {

  protected $eventDispatcher;

  protected function getEditableConfigNames() {
    return ['hello.hello_form_config'];
  }

  public function __construct($eventDispatcher) {
    $this->eventDispatcher = $eventDispatcher;
  }

  public static function create(ContainerInterface $container) {
    return new static(
        $container->get('event_dispatcher')
    );
  }

  /**
   *
   * @ERROR!!!
   *
   */
  public function getFormId() {
    return 'hello_form';
  }

  /**
   *
   * @ERROR!!!
   *
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('hello.hello_form_config');
    $form['my_name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('My name'),
        '#default_value' => $config->get('my_name')
    ];
    $form['my_website'] = [
        '#type' => 'textfield',
        '#title' => $this->t('My website'),
        '#default_value' => $config->get('my_website')
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   *
   * @ERROR!!!
   *
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->config('hello.hello_form_config');

    $config->set('my_name', $form_state->getValue('my_name'))->set('my_website', $form_state->getValue('my_website'));

    $e = new HelloEvent($config);

    $event = $this->eventDispatcher->dispatch('hello_form.save', $e);

    $newData = $event->getConfig()->get();

    $config->merge($newData);

    $config->save();
  }
}