<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a productos api block.
 *
 * @Block(
 *   id = "hello_world_productos_api",
 *   admin_label = @Translation("Productos API"),
 *   category = @Translation("Custom")
 * )
 */
class ProductosApiBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'foo' => $this->t('Hello world!'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['foo'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Foo'),
      '#default_value' => $this->configuration['foo'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['foo'] = $form_state->getValue('foo');
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    // @DCG Evaluate the access condition here.
    $condition = TRUE;
    return AccessResult::allowedIf($condition);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $client = \Drupal::httpClient();
    $options = [
      'headers' => [
        'User-Agent' => 'Drupal',
      ],
    ];
    $response = $client->request('GET', 'https://dummyjson.com/products');

    if ($response->getStatusCode() == '200') {
      $data = $response->getBody()->getContents();
      $data = json_decode($data);

      $product = array_pop($data->products);
      $build['product_' . $product->id] = [
        "#markup" => "<h3>$product->title</h3>",
      ];
    }
    else {
      ksm("error");
    }

    $build['content'] = [
      '#markup' => $this->t('It works!'),
    ];
    return $build;
  }

}
