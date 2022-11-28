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
  public function hello($name = NULL, $nid = NULL) {
    if (!$name) {
      $user = $this->currentUser();
      $name = $user->getAccountName();
    }

    $build['hello'] = [
      '#markup' => '<h2>Hello ' . $name . '!</h2>',
    ];

    ksm($nid);
    if ($nid && is_numeric($nid)) {
      $node = \Drupal\node\Entity\Node::load($nid);
      if ($node) {
        $build['node_info'] = [
          '#title' => $node->getTitle(),
          '#type' => 'link',
          // '#url' => \Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => $nid]),
          '#url' => $node->toUrl(),
        ];
      }
    }

    return $build;
  }

}
