<?php

/**
 * @file
 * Contains \Drupal\Fancyload\Form\FancyloadAdminConfigure.
 */

namespace Drupal\fancyload\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Theme\Registry;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FancyloadConfiguration extends ConfigFormBase {

  /**
   * The theme registry.
   *
   * @var \Drupal\Core\Theme\Registry
   */
  protected $themeRegistry;

  /**
   * Constructs a \Drupal\Fancyload\Form\FancyloadConfiguration object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Theme\Registry $theme_registry
   *   The theme registry.
   */
  public function __construct(ConfigFactoryInterface $config_factory, Registry $theme_registry) {
    parent::__construct($config_factory);

    $this->configuration = $this->config('Fancyload.configuration');
    $this->themeRegistry = $theme_registry;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('theme.registry')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'Fancyload_admin_configure';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('Fancyload.configuration');
    foreach (Element::children($form) as $variable) {
      $config->set($variable, $form_state->getValue($form[$variable]['#parents']));
    }
    $config->save();

    // Rebuild the theme registry if the module was enabled/disabled.
    if ($form['anonymous']['#default_value'] !== $form_state->getValue(['anonymous'])) {
      $this->themeRegistry->reset();
    }

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['Fancyload.configuration'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    if (!file_exists('libraries/responsive-lazy-loader/js/jquery.responsivelazyloader.js') || !file_exists('libraries/responsive-lazy-loader/js/jquery.responsivelazyloader.min.js')) {
      \Drupal::messenger()->addWarning(t("The Responsive lazy loader library could not be found. Download the library <a target=\"_blank\" href=\"https://github.com/jetmartin/responsive-lazy-loader\">here</a>. Place the folder inside the libraries folder so that jquery.responsivelazyloader.js and jquery.responsivelazyloader.min.js are found in libraries/responsive-lazy-loader/js. Visit the Fancyload project page or read the README.md file for more instructions."));
    } else {
      \Drupal::messenger()->addStatus(t("The Responsive lazy loader library is installed correctly."));
    }

    $config = $this->config('Fancyload.configuration');

    $form['anonymous'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Only anonymous users'),
        '#default_value' =>$config->get('anonymous'),
        '#description' => $this->t('Enable fancyload only for anonymous users'),
    ];

    $form['minified'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Use minified javascript'),
        '#default_value' =>$config->get('minified'),
        '#description' => $this->t('Use the minified version of the plugin. Recommended for production.'),
    ];

    return parent::buildForm($form, $form_state);
  }

}
