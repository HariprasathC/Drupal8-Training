<?php

  namespace Drupal\cust_module\Controller;
  use Drupal\Core\Controller\ControllerBase;

class CustModuleController extends ControllerBase{

	public function setting(){

		$systemconfig = \Drupal::service('config.factory')->listAll($prefix = "system");


		foreach($systemconfig as $key=>$data){

			$modcontent .= $systemconfig[$key].'<br>';
		}
	
		  return array(
			'#title' => 'Configuration Systme value',
			'#markup' =>  $modcontent
		);

	}

}


?>