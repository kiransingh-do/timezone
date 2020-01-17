<?php

namespace Drupal\timezone\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block for executing PHP code.
 *
 * @Block(
 *   id = "timezone_block",
 *   admin_label = @Translation("Timezone")
 * )
 */
class TimezoneBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var config
   */
  protected $config;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, array $config) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->config = $config;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {

    return new static(
     $configuration,
     $plugin_id,
     $plugin_definition,
     $container->get('config.storage')->read('time_zone.settings')
    );
  }

  /**
   * Builds and returns the renderable array for this block plugin.
   *
   * @return array
   *   A renderable array representing the content of the block.
   *
   * @see \Drupal\block\BlockViewBuilder
   */
  public function build() {

    // $config = \Drupal::config('time_zone.settings');.
    $service = \Drupal::service('timezone.location');
    $timezone_time = $service->onRespond();
    $country = $this->config['city'];
    $template = [
      '#theme' => 'block--timezone',
      '#country' => $country,
      '#timezone_time' => $timezone_time,
      '#cache' => ['max-age' => 0],
    ];

    return $template;
  }

}
