<?php

namespace Drupal\fancyload\Hooks;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * A theme registry alter implementations.
 */
class ThemeRegistryAlter {

  /** @var \Drupal\Core\Extension\ModuleHandlerInterface */
  protected $moduleHandler;

  /**
   * Creates a new ThemeRegistryAlter instance.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
   *   The module handler.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config
   */
  public function __construct(ModuleHandlerInterface $moduleHandler, ConfigFactoryInterface $config) {
    $this->moduleHandler = $moduleHandler;
    $this->config = $config;
  }

  public function themeRegistryAlter(&$theme_registry) {
      $theme_registry['image']['path'] = $this->moduleHandler->getModule('fancyload')->getPath() . '/templates';
      $theme_registry['image']['template'] = 'fancyload-image';
  }
  
}
