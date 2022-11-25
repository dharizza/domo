<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for HelloWorld.
 */
class HelloWorldController extends ControllerBase {

  /**
   * Returns response with hello world text.
   */
  public function hello() {
    $user = $this->currentUser();

    $build['hello'] = [
      '#markup' => '<h2>Hello ' . $user->getAccountName() . '!</h2>',
    ];

    $build['examples_link'] = [
      '#title' => $this->t('Examples'),
      '#type' => 'link',
      '#url' => \Drupal\Core\Url::fromRoute('<front>'),
    ];

    return $build;
  }

}
