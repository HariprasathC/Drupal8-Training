<?php

namespace Drupal\cust_module\Event;

use Symfony\Component\EventDispatcher\Event;

class CustModuleSubmitEvent extends Event {

  const SAVEFUN = 'custevent.submit';
  protected $namedetails;

  public function __construct($namedetails, $lastid)
  {
    $this->name = $namedetails;
    $this->lastid = $lastid;
  }

  public function getnameValue()
  {
    return $this->name;
  }
  

}