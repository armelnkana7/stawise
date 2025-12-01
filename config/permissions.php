<?php
/* Permissions map by role slug
   Use role names (lowercased and non-alphanum replaced) as keys. Add new permissions as required.
*/
return [
    'superadmin' => [
        'manage_school_years' => true,
        'manage_roles' => true,
        'manage_users' => true,
        'manage_establishments' => true,
        'switch_establishment' => true,
        'view_all_reports' => true,
        'manage_departments' => true,
        'manage_subjects' => true,
        'manage_classes' => true,
        'manage_programs' => true,
    ],
    'censeur' => [
        'manage_users' => true,
        'manage_departments' => true,
        'manage_programs' => true,
        'manage_reports' => true,
        'manage_subjects' => true,
        'manage_classes' => true,
        'view_establishment' => true,
    ],
    'chef_departement' => [
        'record_reports' => true,
        'view_department_reports' => true,
        // chef de departement can also see and manage some classroom/program details in department
        'view_class_and_programs' => true,
    ],
];
