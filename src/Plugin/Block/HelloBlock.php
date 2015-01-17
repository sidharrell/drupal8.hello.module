<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'Hello' block.
 *
 * @Block(
 * id = "hello_block",
 * admin_label = @Translation("Hello block"),
 * )
 */
class HelloBlock extends BlockBase {

  /**
   *
   * {@inheritdoc}
   *
   */
  public function build() {

    $config = $this->getConfiguration();

    if (isset($config['hello_block_settings']) && !empty($config['hello_block_settings'])) {
      $name = $config['hello_block_settings'];
    }
    else {
      $name = $this->t('to no one');
    }

    return array(
        '#markup' => $this->t('Hello @name!', array (
            '@name' => $name,
         )),
    );

  }

  /**
   *
   * {@inheritdoc}
   *
   */
  public function blockAccess(AccountInterface $account) {

    return $account->hasPermission('access content');

  }

  /**
   *
   * {@inheritdoc}
   *
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['hello_block_settings'] = array (
        '#type' => 'textfield',
        '#title' => $this->t('Who'),
        '#description' => $this->t('Who do you want to say hello to?'),
        '#default_value' => isset($config['hello_block_settings']) ? $config['hello_block_settings'] : ''
    );

    return $form;

  }

  /**
   *
   * {@inheritdoc}
   *
   */
  public function blockSubmit($form, FormStateInterface $form_state) {

    $this->setConfigurationValue('hello_block_settings', $form_state->getValue('hello_block_settings'));

  }

}