<?php

// Configuration for the Softzino/EmployeeManagement package
return [
    /*
     * Event dispatching settings for the package.
     * If true, events will be dispatched for actions such as department creation or updates.
     */
    'dispatch_events' => true,

    /*
     * Logging settings for the package's actions.
     * The 'enabled' key controls whether logging is active, and 'log_channel' defines which logging channel to use.
     */
    'logging' => [
        'enabled' => true,
        'log_channel' => 'stack',
    ],

    /*
     * Default values for specific fields, useful for initialization or migrations.
     * These defaults are used when creating new records for departments, designations, etc.
     */
    'defaults' => [
        'department_active' => true,
        'designation_active' => true,
        'employee_active' => true,
    ],

    /*
     * Seed data for database tables.
     * Customize these values to fit your specific use case.
     */
    'seed_data' => [
        'departments' => [
            ['name' => 'Human Resources', 'head_id' => 1, 'created_by' => 1, 'updated_by' => null],
            ['name' => 'Finance', 'head_id' => 1, 'created_by' => 1, 'updated_by' => null],
            ['name' => 'IT Department', 'head_id' => 1, 'created_by' => 1, 'updated_by' => null],
        ],
        'designations' => [
            ['title' => 'Manager', 'created_by' => 1, 'updated_by' => null],
            ['title' => 'Developer', 'created_by' => 1, 'updated_by' => null],
        ],
    ],

    /*
     * Feature toggles for optional features in the package.
     * Enable or disable features depending on your needs.
     */
    'features' => [
        /*
         * Enable or disable the audit trail feature.
         * Tracks changes to departments, designations, and employees for auditing.
         */
        'audit_trails' => true,

        /*
         * Enable or disable notifications for package events.
         * For example, department updates or employee changes.
         */
        'notifications' => false,
    ],
];
