<?php
use App\Core\Database;

/**
 * Convert a role name to slug used in the permissions config
 */
function role_name_to_slug($name)
{
    $slug = preg_replace('/[^a-z0-9]+/', '_', strtolower(trim($name)));
    return trim($slug, '_');
}

/**
 * Get the role name by id
 */
function get_role_name_by_id($id)
{
    $stmt = Database::query('SELECT name FROM roles WHERE id = :id', ['id' => $id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    return $r['name'] ?? null;
}

/**
 * Get configured permissions for a role id
 */
function get_permissions_for_role_id($id)
{
    $name = get_role_name_by_id($id);
    if (!$name) return [];
    $slug = role_name_to_slug($name);
    $map = (is_file(__DIR__ . '/../../config/permissions.php')) ? include __DIR__ . '/../../config/permissions.php' : [];
    return $map[$slug] ?? [];
}

/**
 * Check whether a given role (by id) or user has a given permission.
 * If $user array is provided, we try to read meta['permissions'] overrides.
 */
function role_has_permission($roleId, $permission, $user = null)
{
    $perms = get_permissions_for_role_id($roleId);
    // default: permission present in role config
    if (!empty($perms[$permission])) return true;
    // fallback: if user overrides exist, check them
    if ($user && isset($user['meta'])) {
        $meta = null;
        if (is_string($user['meta'])) {
            $meta = json_decode($user['meta'], true);
        } elseif (is_array($user['meta'])) {
            $meta = $user['meta'];
        }
        if ($meta && isset($meta['permissions'])) {
            $up = $meta['permissions'];
            return in_array($permission, $up);
        }
    }
    return false;
}
