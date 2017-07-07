<?php
namespace Drupal\event_subscribe;

use Symfony\Component\EventDispatcher\Event;

class NodeEvent extends Event {
  const NODE = 'node.insert';
  protected $referenceID;
  public function __construct($referenceID)
  {
    $this->referenceID = $referenceID;
  }
  public function getReferenceID()
  {
    return $this->referenceID;
  }
}
