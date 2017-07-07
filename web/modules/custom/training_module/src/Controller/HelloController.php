<?php
/**
 * @file
 * Contains \Drupal\hello_world\Controller\HelloController.
 */
namespace Drupal\training_module\Controller;
class HelloController {
  public function static_callback() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello! I am your node listing page.'),
    );
  }

  public function dynamic_listing_callback($arg) {
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello! I am your ' . $arg . ' listing page.'),
    );
  }

  public function listing_callback($node) {
    return node_view($node);
  }

}
