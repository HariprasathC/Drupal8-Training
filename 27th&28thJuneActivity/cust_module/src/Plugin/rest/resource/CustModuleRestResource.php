<?php

namespace Drupal\cust_module\Plugin\rest\resource;

use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "cust_module_rest_resource",
 *   label = @Translation("Cust module rest resource"),
 *   uri_paths = {
 *     "canonical" = "/api/v1/user-list"
 *   }
 * )
 */
class CustModuleRestResource extends ResourceBase {

  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->logger = $container->get('logger.factory')->get('cust_module');
    $instance->currentUser = $container->get('current_user');
    return $instance;
  }

    /**
     * Responds to GET requests.
     *
     * @param string $payload
     *
     * @return \Drupal\rest\ResourceResponse
     *   The HTTP response object.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *   Throws exception expected.
     */
    public function get() {

		$database = \Drupal::database();
		$query = $database->query("SELECT * FROM {user_reg}");
		$result = $query->fetchAll();
		
		// $fetchval=[];
		$i = 0;
		foreach($result as $row){ 
				foreach($row as  $key => $val){
						$fetchval[$i][$key]= $val;
				}
			$i++;   
		}
		

		
		// print_R($fetchval);exit;

        // You must to implement the logic of your REST Resource here.
        // Use current user after pass authentication to validate access.
        if (!$this->currentUser->hasPermission('access content')) {
            throw new AccessDeniedHttpException();
        }

        return new ResourceResponse($fetchval, 200);
    }
	
	
	

}
