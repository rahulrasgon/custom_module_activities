<?php

namespace Drupal\custom_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;



/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "weather_block",
 *   admin_label = @Translation("Weather block"),
 *   category = @Translation("custom"),
 * )
 */
class WeatherBlock extends BlockBase implements BlockPluginInterface {

  public function build() {
    $config = $this->getConfiguration();
    $response = \Drupal::service('custom_block.weather')->generateUrl($config['weather_block_name']);
    return array(
      '#theme' => 'weather_template',
      '#temp_min' => $response->main->temp_min,
      '#temp_max' => $response->main->temp_max,
      '#pressure' => $response->main->pressure,
      '#humidity' => $response->main->humidity,
      '#speed' => $response->wind->speed,
      '#city' => $config['weather_block_name'],
      '#attached' => array(
        'library'=> array(
          'custom_form/weather',
          ),
        ),
    );
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['weather_block_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#description' => $this->t('Enter the city name !'),
      '#default_value' => isset($config['weather_block_name']) ? $config['weather_block_name'] : '',
    );

    return $form;
  }

 public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['weather_block_name'] = $values['weather_block_name'];
  }
}
