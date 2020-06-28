<?php

/**
 * @file
 * Contains \Drupal\cust_module\CustModuleEventSubScriber.
 */
namespace Drupal\cust_module\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\cust_module\Event\CustModuleSubmitEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


/**
 * Class CustModuleEventSubScriber.
 *
 * @package Drupal\cust_module
 */
class CustModuleEventSubScriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {	
	return [
      CustModuleSubmitEvent::SAVEFUN => 'myUserLogFun',
    ];

  }

  /**
   * Subscriber Callback for the event.
   * @param CustModuleSubmitEvent $custmodulesubmitevent
   */
  public function myUserLogFun(CustModuleSubmitEvent $custmodulesubmitevent) {
    // return "The Example Event has been subscribed, which has bee dispatched on submit of the form with " . $custmodulesubmitevent->getloggerMsg() . " as Reference");
	echo "test event subcriber";
	\Drupal::logger('cust_module')->notice("The New Form has submitted the name and id is " . $custmodulesubmitevent->getnameValue() .'  '.$custmodulesubmitevent->lastid . " as Reference");
  }


}