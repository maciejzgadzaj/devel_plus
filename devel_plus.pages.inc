<?php

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
