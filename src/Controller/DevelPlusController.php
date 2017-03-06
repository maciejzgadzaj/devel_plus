<?php

namespace Drupal\devel_plus\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for devel module routes.
 */
class DevelPlusController extends ControllerBase {

  /**
   * Builds the field type overview page.
   *
   * @return array
   *   Array of page elements to render.
   */
  public function fieldTypesPage() {
    $field_type_definitions = \Drupal::service('plugin.manager.field.field_type')->getDefinitions();
    ksort($field_type_definitions);
    return \Drupal::service('devel.dumper')->exportAsRenderable($field_type_definitions);
  }

  /**
   * Builds the queues overview page.
   *
   * @return array
   *   Array of page elements to render.
   */
  public function queuesPage() {
    /** @var \Drupal\advancedqueue\Queue\AdvancedQueueWorkerManager $queue_worker_manager */
    $queue_worker_manager = \Drupal::service('plugin.manager.queue_worker');
    $queue_workers = [];
    foreach ($queue_worker_manager->getDefinitions() as $queue_name => $queue_info) {
      /** @var \Drupal\advancedqueue\Queue\AdvancedQueueWorkerInterface $queue_worker */
      $queue_workers[$queue_name] = $queue_worker_manager->createInstance($queue_name);
    }
    return \Drupal::service('devel.dumper')->exportAsRenderable($queue_workers);
  }

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
