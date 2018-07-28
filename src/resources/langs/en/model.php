<?php 

return [
    'menu_item' => [
        'display_name' => 'Menu item',
        'display_name_plural' => 'Menu items',

        'fields' => [
            'name' => [
                'display_name' => 'Name',
            ],
            'inner_link' => [
                'display_name' => 'Inner link',
                'hint' => 'Select the section to which this menu item should refer',
            ],
            'external_link' => [
                'display_name' => 'External link',
                'hint' => 'This link has a greater advantage and will be used even if an internal link has been specified',
            ],
        ],
    ],

    'root' => [
        'fields' => [
            'ga_code' => [
                'display_name' => 'Google Analytics Code',
            ],
        ],
    ],

    'search_category' => [
        'display_name' => 'Menu item',
        'display_name_plural' => 'Menu items',

        'fields' => [
            'name' => [
                'display_name' => 'Name',
            ],

            'model' => [
                'display_name' => 'Model',
            ],
        ],
    ],
];
