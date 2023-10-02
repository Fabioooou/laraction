<?php

/**
 * Laraction configuration
 * ---------------------------
 *
 **/

 return [

    /**
     * define path stubs
     */
 	'stubs' => app_path('stubs'),

    /**
     * Alias namespace
     */
    'namespace_base' => "Actions\\",

    /**
     * define directory Action default
     */
    'path_base' => base_path().'/app/Actions/',

    /**
     * manager
     */
 	'manager' =>
 	[
 		'route' => 'laraction',
 		'schemas' => storage_path('laraction_schemas'),
 	],

    /**
     * Laraction Operations class
     */
    'operations' =>
    [
        'paginate' => [
            'name' => 'Paginate',
            'action' => \Laraction\Operations\Action\PaginateOperationAction::class,
            'view' => \Laraction\Operations\View\PaginateOperationView::class,
        ],
        'create_form' => [
            'name' => 'CreateForm',
            'view' => \Laraction\Operations\View\CreateFormOperationView::class,
            'action' => \Laraction\Operations\Action\CreateFormOperationAction::class,
        ],
        'create' => [
            'name' => 'CreateEntity',
            'view' => \Laraction\Operations\View\CreateOperationView::class,
            'action' => \Laraction\Operations\Action\CreateOperationAction::class,
        ],
        'save_form' => [
            'name' => 'SaveForm',
            'view' => \Laraction\Operations\View\SaveFormOperationView::class,
            'action' => \Laraction\Operations\Action\SaveFormOperationAction::class,
        ],
        'save' => [
            'name' => 'SaveEntity',
            'view' => \Laraction\Operations\View\SaveOperationView::class,
            'action' => \Laraction\Operations\Action\SaveOperationAction::class,
        ],
        'delete' => [
            'name' => 'DeleteEntity',
            'view' => \Laraction\Operations\View\DeleteOperationView::class,
            'action' => \Laraction\Operations\Action\DeleteOperationAction::class,
        ],

    ],


 ];
