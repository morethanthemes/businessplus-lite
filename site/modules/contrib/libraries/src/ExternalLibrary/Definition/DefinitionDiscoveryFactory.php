<?php

namespace Drupal\libraries\ExternalLibrary\Definition;

use Drupal\Component\Serialization\SerializationInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\ClientInterface;

/**
 * Instantiates a library definition discovery based on configuration.
 */
class DefinitionDiscoveryFactory {

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The serializer for files.
   *
   * @var \Drupal\Component\Serialization\SerializationInterface
   */
  protected $jsonSerializer;

  /**
   * The HTTP client used to fetch remote definitions.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Constructs a definition discovery factory.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \Drupal\Component\Serialization\SerializationInterface $json_serializer
   *   The serializer for local definition files.
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client used to fetch remote definitions.
   */
  public function __construct(
    ConfigFactoryInterface $config_factory,
    SerializationInterface $json_serializer,
    ClientInterface $http_client
  ) {
    $this->configFactory = $config_factory;
    $this->jsonSerializer = $json_serializer;
    $this->httpClient = $http_client;
  }

  /**
   * Gets a library definition discovery.
   *
   * @return \Drupal\libraries\ExternalLibrary\Definition\DefinitionDiscoveryInterface
   *   The library definition discovery.
   */
  public function get() {
    $config = $this->configFactory->get('libraries.settings');

    if ($config->get('definition.remote.enable')) {
      $discovery = new ChainDefinitionDiscovery();

      $local_discovery = new WritableFileDefinitionDiscovery(
        $this->jsonSerializer,
        $config->get('definition.local.path')
      );
      $discovery->addDiscovery($local_discovery);

      foreach ($config->get('definition.remote.urls') as $remote_url) {
        $remote_discovery = new GuzzleDefinitionDiscovery(
          $this->httpClient,
          $this->jsonSerializer,
          $remote_url
        );

        $discovery->addDiscovery($remote_discovery);
      }
    }
    else {
      $discovery = new FileDefinitionDiscovery(
        $this->jsonSerializer,
        $config->get('definition.local.path')
      );
    }

    return $discovery;
  }

}
