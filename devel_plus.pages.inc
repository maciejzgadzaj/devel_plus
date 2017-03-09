<?php

/**
 * Menu callback: View Advanced Queue queue definitions.
 *
 * @see devel_plus_menu()
 */
function devel_plus_advancedqueue_queues_page() {
  $queues = advancedqueue_get_queues_info();
  ksort($queues);
  return kprint_r($queues, TRUE);
}

/**
 * Menu callback: View cron queue definitions.
 *
 * @see devel_plus_menu()
 */
function devel_plus_cron_queues_page() {
  $queues = module_invoke_all('cron_queue_info');
  drupal_alter('cron_queue_info', $queues);
  ksort($queues);
  return kprint_r($queues, TRUE);
}

/**
 * Menu callback: View entity property definitions.
 *
 * @see devel_plus_menu()
 */
function devel_plus_entity_properties_page() {
  $property_info = entity_get_property_info();
  ksort($property_info);
  return kprint_r($property_info, TRUE);
}

/**
 * Menu callback: View menu router definitions.
 *
 * @see menu_router_build()
 * @see devel_plus_menu()
 */
function devel_plus_menu_items_page() {
  // Part of menu_router_build().
  $callbacks = array();
  foreach (module_implements('menu') as $module) {
    $router_items = call_user_func($module . '_menu');
    if (isset($router_items) && is_array($router_items)) {
      foreach (array_keys($router_items) as $path) {
        $router_items[$path]['module'] = $module;
      }
      $callbacks = array_merge($callbacks, $router_items);
    }
  }
  drupal_alter('menu', $callbacks);

  ksort($callbacks);
  return kprint_r($callbacks, TRUE);
}

/**
 * Menu callback: View menu router definitions.
 *
 * @see devel_plus_menu()
 */
function devel_plus_menu_router_page() {
  $router = menu_get_router();
  ksort($router);
  return kprint_r($router, TRUE);
}

/**
 * Menu callback: View permission definitions.
 *
 * @see devel_plus_menu()
 */
function devel_plus_permission_info_page() {
  $module_info = system_get_info('module');
  foreach (module_implements('permission') as $module) {
    $modules[$module] = $module_info[$module]['name'];
  }
  ksort($modules);

  $permissions = array();
  foreach ($modules as $module => $display_name) {
    if ($module_permissions = module_invoke($module, 'permission')) {
      $permissions += $module_permissions;
    }
  }

  return kprint_r($permissions, TRUE);
}

/**
 * Menu callback: View views data definitions.
 *
 * @see devel_plus_menu()
 */
function devel_plus_views_data_page() {
  $views_data = views_fetch_data();
  ksort($views_data);
  return kprint_r($views_data, TRUE);
}
