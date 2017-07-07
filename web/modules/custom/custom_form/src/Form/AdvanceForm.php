<?php
namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_form\services\DatabaseQuery;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AdvanceForm extends FormBase {

public function __construct(DatabaseQuery $conn) {
  $this->conn=$conn;
}
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('custom_form.training')

    );
  }

  public function getFormId() {
    return 'advance_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['firstname'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name:'),
      '#required' => TRUE,
    );
    $form['lastname'] = array(
      '#type' => 'textfield',
      '#title' => t('Last Name:'),
      '#required' => TRUE,
    );
    $form['gender'] = array (
      '#type' => 'select',
      '#title' => ('Gender'),
      '#options' => array(
        'UG' => t('U.G'),
        'PG' => t('P.G'),
        'Other' => t('Other'),
      ),
    );
    $form['other'] = array(
    '#title' => t('If others, please specify'),
    '#type' => 'textfield',
    '#states' => array(
      'visible' => array(
        ':input[name="gender"]' => array('value' => 'Other'),
      ),
    ),
  );

    $form['country'] = array (
      '#type' => 'select',
      '#title' => ('Country'),
      '#options' => array(
        '' => t('Choose Country'),
        'India' => t('India'),
        'UK' => t('UK'),
      ),
    );
    $form['indian_state'] = array (
      '#type' => 'select',
      '#title' => ('State'),
      '#options' => array(
        'Rajasthan' => t('Rajasthan'),
        'Madhya Pradesh' => t('Madhya Pradesh'),
        ),
      '#states' => array(
      'visible' => array(
        ':input[name="country"]' => array('value' => 'India'),
      ),
    ),
      );
    $form['uk_state'] = array (
      '#type' => 'select',
      '#title' => ('State'),
      '#options' => array(
        'England' => t('England'),
        'Scotland' => t('Scotland'),
        ),
      '#states' => array(
      'visible' => array(
        ':input[name="country"]' => array('value' => 'UK'),
      ),
    ),
      );

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    );

    return $form;
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
      $form_data = array(
    'first_name' => $form_state->getValue('firstname'),
    'last_name' => $form_state->getValue('lastname'),
  );
      if($this->conn->insertQuery($form_data)) {
        $state = \Drupal::state();
        $state->set('form.store_last', REQUEST_TIME);
        $result=$this->conn->fetchData();
        drupal_set_message($result);
        $time = $state->get('form.store_last');
        drupal_set_message(date("F j, Y, g:i a",$time));
      }
   }
}
