<?php

namespace Drupal\event_subscribe\EventSubscriber;

use Drupal\Core\Path\PathMatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\event_subscribe\NodeEvent;


class MymoduleSubscribe implements EventSubscriberInterface {


  protected $routeMatch;

  public function __construct(CurrentRouteMatch $current_route_match) {
    $this->routeMatch = $current_route_match;
  }

  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = array('addHeaders');
    $events[NodeEvent::NODE][] = array('nodeInsert');
    return $events;
  }

  public function addHeaders(FilterResponseEvent $event) {
    $request = $event->getResponse();
    if ($this->routeMatch->getRouteName()=='entity.node.canonical') {
      $request->headers->set('Access-Control-Allow-Origin', '*');
    }
}

public function nodeInsert(NodeEvent $events)
{
  $data = $events->getReferenceID()->getTitle(). ' node created';
  \Drupal::logger('event_subscribe')->notice($data);
}


}
