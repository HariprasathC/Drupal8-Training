<?php

namespace Drupal\cust_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\drupal_set_message;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Entity\t;
use Drupal\cust_module\Event\CustModuleSubmitEvent;

/**
 * Class Configuration Setting.
 *
 * @package Drupal\student_module\Form
 */
class CustomFormSubmission extends FormBase {

  /**
   * {@inheritdoc}
   */
  // public static function create(ContainerInterface $container) {
  //   return new static(
  //       $container->get('student_module.settings')
  //   );
  // }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // valiodate form values
    // if ($form_state->getValue('name') == '' || $form_state->getValue('rollno') == '' ) {
      // $msg = t('<strong>Name and Role is required!</strong>');
      // $form_state->setErrorByName('form', $msg);
    // }
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
	  
		$current_user = \Drupal::currentUser();
		$user = \Drupal\user\Entity\User::load($current_user->id());


		$user_id = $current_user->id();
		$user_name = $current_user->getUserName();
	
	  
	  // First Name
    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('firstname'),
      '#size' => 60,
      '#maxlength' => 128,
	  '#required' => True,
    ];
		
	// Last Name
    $form['lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('lastname'),
      '#delta' => 2,
	  '#required' => True,
    ];
	
	
		 // Bio.
    $form['bio'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Bio'),
    ];
	
	// Radios.
    $form['gender'] = [
      '#type' => 'radios',
      '#title' => $this->t('Gender'),
      '#options' => ['Male' => $this->t('Male'), 'Female' => $this->t('Female')],
    ];
 

	
	  // $intrest = db_query("SELECT * FROM {taxonomy_term_data} ")->fetchAllKeyed(0,1);
		$vid = 'intrest';
		$terms =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);
		  foreach ($terms as $term) {
		   $intrestval[$term->name] = $term->name; 
		  }
		  
		  
			 
	  $form['intrest'] = array(
		'#type' => 'select',
		'#title' => t('Intrest'),
		'#multiple' => false,
		'#options' => $intrestval,
	  );
	
	 $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
	  '#ajax' => [
        'callback' => '::formsubmit',
      ],
    );


		
    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'cust_module';
  }

  /**
   * {@inheritdoc}
   */
   
   
    public function formsubmit(array $form, FormStateInterface $form_state) {

				$response = new AjaxResponse();

				
				$values = array(
					'first_name' => $form_state->getValues()['firstname'],
					'last_name' => $form_state->getValues()['lastname'],
					'bio' => $form_state->getValues()['bio'],
					'gender' => $form_state->getValues()['gender'],
					'interest' => $form_state->getValues()['intrest']   
				);
				
				
				$insert = db_insert('user_reg')
					-> fields($values)
					->execute();
					
				drupal_set_message($this->t("@message", ['@message' => $values.'Configuration Your Request Sent Successfully ']));				  
			  
					 $dispatcher = \Drupal::service('event_dispatcher');
					 $event = new CustModuleSubmitEvent($form_state->getValues()['firstname'] , $insert);
					$dispatcher->dispatch(CustModuleSubmitEvent::SAVEFUN, $event);   
   echo  $insert;  exit;
					// echo "<pre>";
					// // print_R($values);
					// print_R($value);
					// echo "</pre>"; exit;
   }
   
   
  public function submitForm(array &$form, FormStateInterface $form_state) {

	// $current_user = \Drupal::currentUser();
	// $user = \Drupal\user\Entity\User::load($current_user->id());

	// $user_id = $current_user->id();
	// $user_name = $current_user->getUserName();
	// $formdata['name'] = $user_name;
	// $formdata['rollno'] = $form_state->getValues()['rollno'];
	// $formdata['email'] = $form_state->getValues()['email'];
	// $formdata['userid'] = $user_id;
	// $formdata['status'] = 'Pending';

	// $config = \Drupal::service('student_module.regserive')->registervalue($formdata);
	// $config =  \Drupal::service('config.factory')->getEditable('student_module.settings');
	// $configvalues = $config->get();
	
    // drupal_set_message($this->t("@message", ['@message' => 'Configuration Your Request Sent Successfully ']));
	
  }

  // /**
  //  * {@inheritdoc}
  //  */
  // protected function getEditableConfigNames() {
  //   return ['student_module.settings'];
  // }


}
