<?php
namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
class SimpleForm extends FormBase {

  public function getFormId() {
    return 'simple_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['fullname'] = array(
      '#type' => 'textfield',
      '#title' => t('Name:'),
      '#required' => TRUE,
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    );
    return $form;
  }

   public function validateForm(array &$form, FormStateInterface $form_state) {
      if (strlen($form_state->getValue('fullname')) < 5) {
        $form_state->setErrorByName('fullname', $this->t(' too short. It should be minimum 5 characters'));
      }
    }

  public function submitForm(array &$form, FormStateInterface $form_state) {

      drupal_set_message($this->t($form_state->getValue('fullname')));
   }
}
