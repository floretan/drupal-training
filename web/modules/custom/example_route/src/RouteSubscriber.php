<?php

namespace Drupal\example_route;

use \Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;
use Drupal\Core\Routing\RoutingEvents;

class RouteSubscriber extends RouteSubscriberBase {

  public function alterRoutes(RouteCollection $collection) {

    $filter_route = $collection->get('filter.tips_all');

    $filter_route->addRequirements([
      'permission' => 'edit content',
    ]);

//    $collection->remove('filter.tips_all');
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = parent::getSubscribedEvents();
    $events[RoutingEvents::ALTER] = array('onAlterRoutes', -100);
    return $events;
  }
}