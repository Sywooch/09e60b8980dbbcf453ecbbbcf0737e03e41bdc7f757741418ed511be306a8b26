<?php

return [
    0 => ['name' => 'Новости',
        'model' => 'News',
        'home' => ['db_buttons' => '']
    ],
    1 => ['name' => 'Организации',
        'model' => 'Organizations',
        'home' => ['db_buttons' => 'section_id', 'cat_id' => TRUE]
    ],
    2 => ['name' => 'Акции',
        'model' => 'Shares',
        'home' => ['db_buttons' => 'section_id']
    ],
    3 => ['name' => 'Афиша',
        'model' => 'Poster',
        'home' => ['db_buttons' => 'section_id']
    ],
    4 => ['name' => 'Ссылка',
        'model' => 'Url',
        'home' => ['db_buttons' => 'url']
    ],
    5 => ['name' => 'Телефонный звонок',
        'model' => 'Tel',
        'home' => ['db_buttons' => 'telephone']
    ],
];
