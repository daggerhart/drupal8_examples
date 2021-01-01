<?php

namespace Drupal\cookie_services\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;

/**
 * Provides a very simple block that displays some text.
 *
 * @Block(
 *   id = "block_using_custom_cache_context",
 *   admin_label = @Translation("Block Using Custom Cache Context From Cookie Service")
 * )
 */
class BlockUsingCustomCacheContext extends BlockBase {

  /**
   * {@inheritDoc}
   */
  public function build() {
    \Drupal::messenger()->addStatus('Block is not cached - ' . __CLASS__);

    return [
      '#cache' => [
        'contexts' => [
          'another_cookie_service_complex_city'
        ],
      ],
      '#markup' => Markup::create('
        <p><strong>Note:</strong> Caching must be enabled to test this properly.</p>
        <hr>
        <p>
        Example custom cache context using cookie data.<br>
        If this block not cached you should see a message indicating it is not cached.<br>
        If it is cached, you should not see any message mentioning this blocks cached state.
        </p>
      '),
    ];
  }

}
