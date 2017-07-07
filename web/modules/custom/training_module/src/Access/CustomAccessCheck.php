<?php
namespace Drupal\training_module\Access;

use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Access\AccessResult;
use Symfony\Component\Routing\Route;
use Drupal\Core\Routing\RouteMatch;
use Drupal\Core\Session\AccountInterface;
class CustomAccessCheck implements AccessInterface {
    protected $node_id;
    protected $user_id;
    protected $account;
  public function __construct(AccountInterface $account) {
    $this->account=$account;
  }

  public function access(Route $route, RouteMatch $route_match) {

    $this->user_id=$this->account->id();

    $this->node_id=$route_match->getParameter('node')->getOwnerId();
    if ($this->user_id == $this->node_id) { // check if a user has legs
      return AccessResult::allowed(); // denied! No legs.
    }
    return AccessResult::forbidden(); // OK to access trousers
  }
}
