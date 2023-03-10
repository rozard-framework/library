<?php



/*** VERSION 4 */

function service_example_test( $scheme ) {

       /**
     *  
     *  syntax: 
     *  $scheme[$scheme][$arguments]
     * 
     *  example:
     *  $scheme['config']['remove']
     *    
     *  @param  $scheme  =  scheme name       
     *  @param  $action  =  operation mode  -  remove | enroll
     */


    /*** FIELD - MASTER */
    $field_master = array(
        'checkbox' => array(
            'type'  =>  'checkbox',
            'keys'  =>  'field_checkbox',
            'name'  =>  'Checkbox Field',
            'desc'  =>  'Example checkbox description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ), 
        'color' => array(
            'type'  =>  'color',
            'keys'  =>  'field_color',
            'name'  =>  'Color Field',
            'desc'  =>  'Example color description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ), 
        'date' => array(
            'type'  =>  'date',
            'keys'  =>  'field_date',
            'name'  =>  'Date Field',
            'desc'  =>  'Example color description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ), 
        'datetime' => array(
            'type'  =>  'datetime',
            'keys'  =>  'field_datetime',
            'name'  =>  'Datetime Field',
            'desc'  =>  'Example datetime description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ), 
        'editor' => array(
            'type'  =>  'editor',
            'keys'  =>  'field_editor',
            'name'  =>  'Editor Field',
            'desc'  =>  'Example editor description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ), 
        'html' => array(
            'type'  =>  'html',
            'keys'  =>  'field_html',
            'name'  =>  'Html Field',
            'desc'  =>  'Example html description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(),
            'value' => '<h2> Karim </h2><p> Azaza </p>',
        ), 
        'email' => array(
            'type'  =>  'email',
            'keys'  =>  'field_email',
            'name'  =>  'Email Field',
            'desc'  =>  'Example email description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ),
        'hidden' => array(
            'type'  =>  'hidden',
            'keys'  =>  'field_hidden',
            'name'  =>  'Hidden Field',
            'desc'  =>  'Example hidden description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ),
        'image' => array(
            'type'  =>  'image',
            'keys'  =>  'field_image',
            'name'  =>  'Image Field',
            'desc'  =>  'Example image description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => 'https://www.w3schools.com/tags/img_submit.gif',
        ),
        'month' => array(
            'type'  =>  'month',
            'keys'  =>  'field_month',
            'name'  =>  'Month Field',
            'desc'  =>  'Example month description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ),
        'password' => array(
            'type'  =>  'password',
            'keys'  =>  'field_password',
            'name'  =>  'Password Field',
            'desc'  =>  'Example password description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ),
        'radio' => array(
            'type'  =>  'radio',
            'keys'  =>  'field_radio',
            'name'  =>  'Radio Field',
            'desc'  =>  'Example radio description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ),
        'phone' => array(
            'type'  =>  'phone',
            'keys'  =>  'field_phone',
            'name'  =>  'Phone Field',
            'desc'  =>  'Example phone description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ),
        'range' => array(
            'type'  =>  'range',
            'keys'  =>  'field_range',
            'name'  =>  'Range Field',
            'desc'  =>  'Example range description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ),
        'select' => array(
            'type'  =>  'select',
            'keys'  =>  'field_select',
            'name'  =>  'Select Field',
            'desc'  =>  'Text description',
            'caps'  =>  'post',
            'cols'  =>  50,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'list'  =>  array(
                'printed' => 'Printed',
                'digital' => 'Digital',
            )
        ), 
        'switch' => array(
            'type'  =>  'switch',
            'keys'  =>  'field_switch',
            'name'  =>  'Switch Field',
            'desc'  =>  'Example switch description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ),
        'text' => array(
            'type'  =>  'text',
            'keys'  =>  'field_text',
            'name'  =>  'Text Field',
            'desc'  =>  'Example text description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ), 
        'textarea' => array(
            'type'  =>  'textarea',
            'keys'  =>  'field_textarea',
            'name'  =>  'Textarea Field',
            'desc'  =>  'Example textarea description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ),
        'time' => array(
            'type'  =>  'time',
            'keys'  =>  'field_time',
            'name'  =>  'Time Field',
            'desc'  =>  'Example time description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ),
        'url' => array(
            'type'  =>  'url',
            'keys'  =>  'field_url',
            'name'  =>  'Url Field',
            'desc'  =>  'Example url description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ),
        'week' => array(
            'type'  =>  'week',
            'keys'  =>  'field_week',
            'name'  =>  'Week Field',
            'desc'  =>  'Example week description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ),
        'number' => array(
            'type'  =>  'number',
            'keys'  =>  'field_number',
            'name'  =>  'Number Field',
            'desc'  =>  'Example number description',
            'caps'  =>  'manage_options',
            'cols'  =>  100,
            'cryp'  =>  false,
            'cond'  =>  array(

            ),
            'attr'  =>  array(
                'placeholder' => 'insert text please',
                'require'     => true,
            ),
            'value' => '',
        ), 
    );



    /*** FORM - GENERAL */

    $scheme['former']['test_1'] = array(
        'keys' => 'test_1',         // setting keys
        'name' => 'Test Form',      // form title 
        'icon' => '',               // feature icon
        'desc' => 'Description',    // setting descroption
        'caps' => 'read',           // capabilities
        'save' => 'user',           // setting | site | term | user | post | dbms | option | theme | feed
        'type' => 'service',        // system | service | theme              
        'mode' => 'plain',          // layout mode   
        'form' => array(
            'group_a' => array(
                'name'  =>  '',
                'desc'  =>  '',
                'icon'  =>  'Sites 2',        // feature icon
                'caps'  =>  '',
                'cond'  =>  array(

                ),
                'field' => array(
                    'test' => array(
                        'type'  =>  'text',
                        'keys'  =>  'agile_text',
                        'name'  =>  'Agile One',
                        'desc'  =>  'Text description',
                        'caps'  =>  'manage_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'hore' => array(
                        'type'  =>  'text',
                        'keys'  =>  'karim_agile',
                        'name'  =>  'Agile Two',
                        'desc'  =>  'Text description',
                        'caps'  =>  'manage_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                ),
            ),
        ),
    );


    $scheme['former']['test_2'] = array(
        'keys' => 'test_2',         // setting keys
        'name' => 'Test Form',      // form title 
        'icon' => '',               // feature icon
        'desc' => 'Description',    // setting descroption
        'caps' => 'read',           // capabilities
        'save' => 'user',           // setting | site | term | user | post | dbms | option | theme | feed
        'type' => 'service',        // system | service | theme   
        'mode' => 'plain',          // layout mode
        'form' => array(
            'group_1' => array(
                'name'  => '',
                'icon'  => 'Sites 2',        // feature icon
                'desc'  => '',
                'caps'  => '',
                'cond'  => array(

                ),
                'field' => array(
                    'test' => array(
                        'type'  =>  'text',
                        'keys'  =>  'hafidzah_text',
                        'name'  =>  'Zaza Text',
                        'desc'  =>  'Text description',
                        'caps'  =>  'manage_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'hore' => array(
                        'type'  =>  'text',
                        'keys'  =>  'karim_text',
                        'name'  =>  'Karim Text',
                        'desc'  =>  'Text description',
                        'caps'  =>  'manage_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                ),
            ),
        ),
    );


    $scheme['former']['test_3'] = array(
        'keys' => 'test_3',         // setting keys
        'name' => 'Test Form',      // form title     
        'icon' => 'Setting 3',      // feature icon
        'desc' => 'Description',    // setting descroption
        'caps' => 'read',           // capabilities
        'save' => 'site',           // setting | site | term | user | post | dbms | option | theme | feed           
        'type' => 'service',        // system | service | theme                  
        'mode' => 'plain',          // layout mode      
        'form' => array(
            'group_a' => array(
                'name'  =>  '',
                'icon'  =>  'Sites 2',        // feature icon
                'desc'  =>  '',
                'caps'  =>  '',
                'cond'  =>  array(

                ),
                'field' => array(
                    'test' => array(
                        'type'  =>  'text',
                        'keys'  =>  'agile_text',
                        'name'  =>  'Agile One',
                        'desc'  =>  'Text description',
                        'caps'  =>  'manage_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'hore' => array(
                        'type'  =>  'text',
                        'keys'  =>  'karim_agile',
                        'name'  =>  'Agile Two',
                        'desc'  =>  'Text description',
                        'caps'  =>  'manage_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                ),
            ),
        ),
    );


    /*** STRUCTURE */

    $scheme['service']['structure'] = array(
        'layout' => array(
            'cockpit' => 'right-sidebar',
            'formats' => 'right-sidebar',
            'manages' => 'right-sidebar',
            'wizard'  => 'right-sidebar',
            'setting' => 'right-sidebar',
        ),
    );



    /**
     *  CONFIG 
     * 
     *  syntax: 
     *  $scheme[$scheme][$level]
     * 
     *  example:
     *  $scheme['config']['core']
     *  $scheme['config']['node']
     *    
     *  @param  $scheme  =  scheme name       
     *  @param  $action  =  levels mode  -  node | core
     */


    $scheme['service']['options'][] = array(
        'keys' => 'general',                // setting keys
        'name' => 'Config',                 // page title
        'menu' => '',                       // menu name
        'desc' => 'Option Deskripsi',       // option description
        'icon' => 'Theme Config 1',         // module title
        'caps' => 'read',                   // capabilities
        'node' => 'options',                // system | {$custom_prefix}  
        'cell' => 'karim',                  // sub node name
        'sort' => 50,                       // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'test_1',          // former id
        ), 
    );



    $scheme['service']['options'][] = array(
        'keys' => 'publish_user',          // setting keys
        'name' => 'User Publish',          // module title
        'menu' => '',                      // menu name
        'desc' => 'Contoh Deskripsi',      // option description 
        'icon' => 'Theme Config 1',        // module title
        'caps' => 'read',                  // capabilities
        'node' => 'options',               // system | {$custom_prefix}  
        'cell' => 'karim',                 // sub node name
        'sort' => 50,                      // posisition (int)
        'view' => '',                      // layout
        'load' => array(
            'former' =>  'test_2',         // former id
        ),
    );


    $scheme['service']['options'][] = array(
        'keys' => 'application',            // setting keys
        'name' => 'Application',            // page title
        'menu' => '',                       // menu name
        'desc' => 'Option Deskripsi',       // option description 
        'icon' => 'Theme Config 1',         // module title
        'caps' => 'read',                   // capabilities
        'node' => 'options',                // system | {$custom_prefix}  
        'cell' => 'karim',                  // sub node name
        'sort' => 50,                       // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'test_2',          // former id
        ),
    );



     /**
     *  MANAGES 
     * 
     *  syntax: 
     *  $scheme[$scheme][$level]
     * 
     *  example:
     *  $scheme['feeder']['form']
     *  $scheme['feeder']['hook']
     * 
     *  @param  $scheme  =  scheme name       
     *  @param  $module  =  module type - core | page 
     */


    $scheme['service']['feeder'][] = array(
        'keys' => 'disquz',                // setting keys
        'name' => 'Disqus',                // module title
        'menu' => '',                      // menu name
        'desc' => 'Disqus Deskripsi',      // option description 
        'icon' => 'Disqus Config 1',       // module title
        'caps' => 'read',                  // capabilities
        'node' => 'feedback',              // feedback | {$custom_prefix}
        'cell' => 'karim',                 // sub node name
        'sort' => 50,                      // posisition (int)
        'view' => '',                      // layout
        'load' => array(
            'former' =>  'test_2',         // former id
        ),
    );


    $scheme['service']['feeder'][] = array(
        'keys' => 'twitter',               // setting keys
        'name' => 'Twitter',               // module title
        'menu' => '',                      // menu name
        'desc' => 'Twitter Deskripsi',     // option description 
        'icon' => 'Twitter Config 1',      // module title
        'caps' => 'read',                  // capabilities
        'node' => 'feedback',              // feedback | {$custom_prefix}  
        'cell' => 'karim',                  // sub node name
        'sort' => 50,                      // posisition (int)
        'view' => '',                      // layout
        'load' => array(
            'former' =>  'test_3',         // former id
        ),
    );


    $scheme['service']['manage'][] = array(
        'keys' => 'user_1',                // setting keys
        'name' => 'User 1',                // module title
        'menu' => '',                      // menu name
        'desc' => 'Twitter Deskripsi',     // option description 
        'icon' => 'Twitter Config 1',      // module title
        'caps' => 'read',                  // capabilities
        'node' => 'system',                // system | feeder | toolkit | {$custom_prefix}
        'cell' => 'users',                 // user | themes | plugins | {$custom_prefix}
        'sort' => 50,                      // posisition (int)
        'view' => '',                      // layout
        'load' => array(
            'former' =>  'test_3',         // former id
        ),
    );


    $scheme['service']['manage'][] = array(
        'keys' => 'user_2',               // setting keys
        'name' => 'User 2',               // module title
        'menu' => '',                     // menu name
        'desc' => 'Twitter Deskripsi',    // option description 
        'icon' => 'Twitter Config 1',     // module title
        'caps' => 'read',                 // capabilities
        'node' => 'system',                // system | feeder | toolkit | {$custom_prefix}
        'cell' => 'Karim',                // sub node name     
        'sort' => 50,                     // posisition (int)
        'view' => '',                     // layout
        'load' => array(
            'former' =>  'test_3',        // former id
        ),
    );




     /**
     *  COCKPIT 
     * 
     *  syntax: 
     *  $scheme[$scheme][$level]
     * 
     *  example:
     *  $scheme['feeder']['form']
     *  $scheme['feeder']['hook']
     * 
     *  @param  $scheme  =  scheme name       
     *  @param  $module  =  module type  -  core | page 
     */
   
    $scheme['service']['cockpit'][] = array(
        'keys' => 'twitter',               // setting keys
        'name' => 'Twitter',               // module title
        'menu' => '',                      // menu name
        'desc' => 'Twitter Deskripsi',     // option description 
        'icon' => 'Twitter Config 1',      // module title
        'caps' => 'read',                  // capabilities
        'node' => 'sosmed',                // {$custom_prefix}  
        'cell' => 'Karim',                 // sub node name
        'sort' => 50,                      // posisition (int)
        'view' => '',                      // layout
        'load' => array(
            'former' =>  'test_3',         // former id
        ),
    );

    return $scheme;
}
add_filter( 'register_scheme', 'service_example_test'  );
 
