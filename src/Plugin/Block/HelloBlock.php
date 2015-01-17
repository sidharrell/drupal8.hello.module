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

    // retrieve the configuration for this instance
    $config = $this->getConfiguration();

    if (isset($config['hello_block_name']) && !empty($config['hello_block_name'])) {
      $name = $config['hello_block_name'];
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

    // When the module is activated, it will pull the contents of config/install/hello.settings.yml into
    // the system configuration stored in the database
    $default_config = \Drupal::config('hello.settings');

    // This will retrieve the configuration of this particular instance of a HelloBlock
    $config = $this->getConfiguration();

    $form['hello_block_name'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('Who'),
        '#description' => $this->t('Who do you want to say hello to?'),
        // If there isn't a value set for this instance, it must be a new instance, so use the system config
        '#default_value' => isset($config['hello_block_name']) ? $config['hello_block_name'] : $default_config->get('hello.name')
    );
    $form['hello_block_overwrite'] = array(
        '#type' => 'checkbox',
        '#title' => $this->t('Overwrite system default?'),
    );

    return $form;

  }

  /**
   *
   * {@inheritdoc}
   *
   */
  public function blockSubmit($form, FormStateInterface $form_state) {

    // Place the value from the form submission into the configuration for this instance
    $this->setConfigurationValue('hello_block_name', $form_state->getValue('hello_block_name'));

    // If the checkbox on the form is checked, save the name to the system configuration for use by new instances
    if ($form_state->getValue('hello_block_overwrite')) {
      $config = \Drupal::config('hello.settings');
      $config->set('hello.name', $form_state->getValue('hello_block_name'));
      $config->save();
    }

  }

}