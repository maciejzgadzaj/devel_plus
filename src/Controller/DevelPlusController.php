<?php

namespace Drupal\devel_plus\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for devel module routes.
 */
class DevelPlusController extends ControllerBase {

  /**
   * Builds the routes overview page.
   *
   * @return array
   *   Array of page elements to render.
   */
  public function routesPage() {
    /** @var \Drupal\Core\Routing\RouteProvider $route_provider */
    $route_provider = \Drupal::service('router.route_provider');
    $routes = array();
    foreach ($route_provider->getAllRoutes() as $route_name => $route) {
      $routes[$route_name] = $route;
    }
    return \Drupal::service('devel.dumper')->exportAsRenderable($routes);
  }

  /**
   * Builds the views data overview page.
   *
   * @return array
   *   Array of page elements to render.
   */
  public function viewsDataPage() {
    /** @var \Drupal\views\ViewsData $views_data */
    $views_data = \Drupal::getContainer()->get('views.views_data');
    return \Drupal::service('devel.dumper')->exportAsRenderable($views_data->getAll());
  }

}
