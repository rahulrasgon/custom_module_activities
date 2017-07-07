<?php
namespace Drupal\custom_form\Form;
use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;

class WeatherForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'weather_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'weather.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('weather.settings');
    $form['appid'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('APP ID'),
      '#default_value' => $config->get('weatherconfig.appid'),
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    error_log($values);
    $this->config('weather.settings')
      ->set('weatherconfig.appid', $values['appid'])
      ->save();
  }

}
