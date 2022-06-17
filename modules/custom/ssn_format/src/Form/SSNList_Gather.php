<?php
/**
 * @file
 * Contains \Drupal\ssn_format\Form\SSNList_Gather.
 */
namespace Drupal\ssn_format\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SSNList_Gather extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ssnlist_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['ssn'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter SSN:'),
      '#required' => TRUE,
    );

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit your SSN'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    if(strlen($form_state->getValue('ssn')) !== 9 || !is_numeric($form_state->getValue('ssn'))) {
      $form_state->setErrorByName('ssn', $this->t('Please enter a valid SSN using only intergers; dashes are not accepted'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::messenger()->addMessage(t("Thanks for submitting that SSN!!"));
    foreach ($form_state->getValues() as $key => $value) {
      if($key == 'ssn') {
        $formatted_ssn = preg_replace("/^(\d{3})(\d{2})(\d{4})$/", "$1-$2-$3", $value);
        \Drupal::messenger()->addMessage('Social Security Number in dash format: ' . $formatted_ssn);
      }
    }
    \Drupal::messenger()->addMessage(t("You can submit another SSN below for dash formatting . . . "));
  }
}
