<?php

/**
 * @file
 * Contains \Drupal\hello\Form\HelloForm.
 */

namespace Drupal\hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class HelloForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {

    return 'demo_form';

  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['email'] = array(
        '#type' => 'email',
        '#title' => $this->t('Your .com email address.')
    );
    $form['show'] = array(
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
    );

    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    if (strpos($form_state->getValue('email'), '.com') === FALSE ) {
      $form_state->setErrorByName('email', $this->t('This is not a .com email address.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    drupal_set_message($this->t('Your email address is @email', array('@email' => $form_state->getValue('email'))));
  }

}