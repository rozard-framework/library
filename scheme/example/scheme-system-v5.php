<?php


function register_example_system( $scheme ) {
    /**
     *  SCHEME SYSTEM V5
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
 

    $scheme['former']['form_1'] = array(
        'keys' => 'form_1',
        'name' => 'application',    // seting name   
        'icon' => 'Sites 2',        // feature icon
        'desc' => 'Description',    // setting descroption
        'caps' => 'read',           // capabilities
        'save' => 'option',         // setting | site | term | user | post | dbms | option | theme           
        'type' => 'system',         // system | service | theme             
        'mode' => 'plain',          
        'form' => array(
            'default' => array(
                'name'  =>  ' Default',
                'desc'  =>  'Theme 1  Config Group',
                'icon'  =>  'Sites 2',        // feature icon
                'caps'  =>  '',
                'cond'  =>  array(

                ),
                'field' =>  $field_master,
            ),
            'karim' => array(
                'name'  =>  'Karim',
                'desc'  =>  'Theme Karim Config Group',
                'icon'  =>  'Sites 2',        // feature icon
                'caps'  =>  '',
                'cond'  =>  array(

                ),
                'field' => array(
                    'test' => array(
                        'type'  =>  'text',
                        'keys'  =>  'config_one_text',
                        'name'  =>  'Config One Text',
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
                        'value' => '',
                    ), 
                    'hore' => array(
                        'type'  =>  'number',
                        'keys'  =>  'config_two_agile',
                        'name'  =>  'Config One Number',
                        'desc'  =>  'Text description',
                        'caps'  =>  'manage_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr' => array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                        'value' => '',
                    ), 
                ),
            ),
        ),
    );

    $scheme['former']['form_2'] = array(
        'keys' => 'form_2',
        'name' => 'Test Form',       
        'icon' => 'Sites 2',        // feature icon
        'desc' => 'Description',    // setting descroption
        'caps' => 'read',           // test
        'data' => 'user',           // site | term | user | post | dbms | option | theme_mod
        'type' => 'system',         // system | service | theme   
        'mode' => 'plain',          // 
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
    


    /**
     * 
     *  NETWORK MULTISITE
     * 
     *  syntax: 
     *  $scheme[$scheme][$scopes]
     * 
     *  example:
     *  $scheme['system']['insight']
     *  $scheme['system']['module']
     * 
     *  @param  $scheme   =  scheme name       
     *  @param  $scopes   =  subpage name , insight | module | manage | setting | custom
     * 
     */


    $scheme['system']['structure'] = array(
        'layout' => array(
            'insight' => 'right-sidebar',
            'service' => 'right-sidebar',
            'manage'  => 'right-sidebar',
            'wizard'  => 'right-sidebar',
            'setting' => 'right-sidebar',
        ),
    );


    $scheme['system']['setting'][] = array(
        'keys' => 'application',            // module keys
        'name' => 'Application',            // page title
        'menu' => '',                       // menu name
        'desc' => 'Option Deskripsi',       // option description 
        'icon' => 'Theme Config 1',         // module title
        'caps' => 'read',                   // capabilities
        'node' => 'application',            // module group
        'cell' => 'Karim',                  // sub node name
        'sort' => 50,                       // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ),                 
    );

    
    $scheme['system']['setting'][] = array(
        'keys' => 'luring',                 // module keys
        'name' => 'Luring',                 // page title
        'menu' => '',                       // menu name
        'desc' => 'Luring Deskripsi',       // option description 
        'icon' => 'Theme Config 1',         // module title
        'caps' => 'read',                   // capabilities
        'node' => 'application',            // module group
        'cell' => 'Karim',                  // sub node name
        'sort' => 50,                       // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );


    $scheme['system']['insight'][] = array(
        'keys' => 'insight_1',              // module keys
        'name' => 'Insight 1',              // page title
        'menu' => '',                       // menu name
        'desc' => 'Option Deskripsi',       // option description 
        'icon' => 'Theme Config 1',         // module title
        'caps' => 'read',                   // capabilities
        'node' => 'website',                // module group
        'cell' => 'Karim',                  // sub node name
        'sort' => 50,                       // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );


    $scheme['system']['insight'][] = array(
        'keys' => 'insight_2',              // module keys
        'name' => 'Insight 2',              // page title
        'menu' => '',                       // menu name
        'desc' => 'Luring Deskripsi',       // option description 
        'icon' => 'Theme Config 1',         // module title
        'caps' => 'read',                   // capabilities
        'node' => 'general',                // module group
        'cell' => 'Karim',                  // sub node name
        'sort' => 50,                       // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );


    $scheme['system']['wizard'][] = array(
        'keys' => 'wizard_1',               // module keys
        'name' => 'wizard 1',               // page title
        'menu' => '',                       // menu name
        'desc' => 'Option Deskripsi',       // option description 
        'icon' => 'Theme Config 1',         // module title
        'caps' => 'read',                   // capabilities
        'node' => 'system',                 // system | feeder | toolkit | {$custom_prefix}
        'cell' => 'Karim',                  // sub node name
        'sort' => 50,                       // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );


    $scheme['system']['wizard'][] = array(
        'keys' => 'wizard_2',              // module keys
        'name' => 'wizard 2',              // page title
        'menu' => '',                      // menu name
        'desc' => 'Luring Deskripsi',      // option description 
        'icon' => 'Theme Config 1',        // module title
        'caps' => 'read',                  // capabilities
        'node' => 'system',                // system | feeder | toolkit | {$custom_prefix}
        'cell' => 'Karim',                  // sub node name
        'sort' => 50,                      // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );


    $scheme['system']['service'][] = array(
        'keys' => 'module_1',               // module keys
        'name' => 'module 1',               // page title
        'menu' => '',                       // menu name
        'desc' => 'Option Deskripsi',       // option description 
        'icon' => 'Theme Config 1',         // module title
        'caps' => 'read',                   // capabilities
        'node' => 'system',                // system | feeder | toolkit | {$custom_prefix}
        'cell' => 'Karim',                  // sub node name
        'sort' => 50,                       // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );


    $scheme['system']['service'][] = array(
        'keys' => 'module_2',              // module keys
        'name' => 'module 2',              // page title
        'menu' => '',                      // menu name
        'desc' => 'Luring Deskripsi',      // option description 
        'icon' => 'Theme Config 1',        // module title
        'caps' => 'read',                  // capabilities
        'node' => 'system',                // system | feeder | toolkit | {$custom_prefix}
        'cell' => 'Karim',                 // sub node name
        'sort' => 50,                      // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );


    $scheme['system']['manage'][] = array(
        'keys' => 'userman_1',              // module keys
        'name' => 'User Test',              // page title
        'menu' => '',                       // menu name
        'desc' => 'Option Deskripsi',       // option description 
        'icon' => 'Theme Config 1',         // module title
        'caps' => 'read',                   // capabilities
        'node' => 'system',                 // system | feeder | toolkit | {$custom_prefix}
        'cell' => 'Karim',                  // sub node name
        'sort' => 50,                       // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );


    $scheme['system']['manage'][] = array(
        'keys' => 'plugins_2',              // module keys
        'name' => 'manage 2',              // page title
        'menu' => '',                      // menu name
        'desc' => 'Luring Deskripsi',      // option description 
        'icon' => 'Theme Config 1',        // module title
        'caps' => 'read',                  // capabilities
        'node' => 'system',                // system | feeder | toolkit | {$custom_prefix}
        'cell' => 'Karim',                  // sub node name
        'sort' => 50,                      // menu posisition (int)
        'view' => '',                      // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );


    $scheme['system']['manage'][] = array(
        'keys' => 'themes_1',              // module keys
        'name' => 'Themes Test 1',         // page title
        'menu' => '',                      // menu name
        'desc' => 'Luring Deskripsi',      // option description 
        'icon' => 'Theme Config 1',        // module title
        'caps' => 'read',                  // capabilities
        'node' => 'system',                // system | feeder | toolkit | {$custom_prefix}
        'cell' => 'Karim',                  // sub node name
        'sort' => 50,                      // menu posisition (int)
        'view' => '',                      // layout
        'load' => array(
            'former' =>  'form_1',         // former id
        ), 
    );


    $scheme['system']['manage'][] = array(
        'keys' => 'custom_1',              // module keys
        'name' => 'Custom Test 1',         // page title
        'menu' => '',                      // menu name
        'desc' => 'Luring Deskripsi',      // option description 
        'icon' => 'Theme Config 1',        // module title
        'caps' => 'read',                  // capabilities
        'node' => 'system',                // system | feeder | toolkit | {$custom_prefix}
        'cell' => 'Karim',                 // sub node name
        'sort' => 50,                      // menu posisition (int)
        'view' => '',                      // layout
        'load' => array(
            'former' =>  'form_1',         // former id
        ), 
    );


    $scheme['system']['manage'][] = array(
        'keys' => 'custom_2',              // module keys
        'name' => 'Custom Test 2',         // page title
        'menu' => '',                      // menu name
        'desc' => 'Luring Deskripsi',      // option description 
        'icon' => 'Theme Config 1',        // module title
        'caps' => 'read',                  // capabilities
        'node' => 'system',                // system | feeder | toolkit | {$custom_prefix}
        'cell' => 'Karim',                 // sub node name
        'sort' => 50,                      // menu posisition (int)
        'view' => '',                      // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );


    $scheme['system']['manage'][] = array(
        'keys' => 'custom_3',              // module keys
        'name' => 'Custom Test 3',         // page title
        'menu' => '',                      // menu name
        'desc' => 'Luring Deskripsi',      // option description 
        'icon' => 'Theme Config 1',        // module title
        'caps' => 'read',                  // capabilities
        'node' => 'system',                // system | feeder | toolkit | {$custom_prefix}
        'cell' => 'Karim',                 // sub node name
        'sort' => 50,                      // menu posisition (int)
        'view' => '',                      // layout
        'load' => array(
            'former' =>  'form_1',         // former id
        ), 
    );


    $scheme['system']['karims'][] = array(
        'keys' => 'karims_1',               // module keys
        'name' => 'Karim 1',                // page title
        'menu' => '',                       // menu name
        'desc' => 'Luring Deskripsi',       // option description 
        'icon' => '',                       // module title
        'caps' => 'read',                   // capabilities
        'node' => 'ronald',                 // users | themes | plugins | {$custom_prefix}
        'cell' => 'karim',                  // sub node name
        'sort' => 50,                       // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );

    
    $scheme['system']['karims'][] = array(
        'keys' => 'karims_2',               // module keys
        'name' => 'Karim 2',                // page title
        'menu' => '',                       // menu name
        'desc' => 'Luring Deskripsi',       // option description 
        'icon' => '',                       // module title
        'caps' => 'read',                   // capabilities
        'node' => 'ronald',                 // users | themes | plugins | {$custom_prefix}
        'cell' => 'karim',                  // sub node name
        'sort' => 50,                       // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );


    $scheme['system']['zaza'][] = array(
        'keys' => 'zaza_1',                 // module keys
        'name' => 'roboto 1',               // page title
        'menu' => '',                       // menu name
        'desc' => 'Luring Deskripsi',       // option description 
        'icon' => '',                       // module title
        'caps' => 'read',                   // capabilities
        'node' => 'zoro',                   // users | themes | plugins | {$custom_prefix}
        'cell' => 'Karim',                  // sub node name
        'sort' => 50,                       // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );


    $scheme['system']['zaza'][] = array(
        'keys' => 'zaza_2',                 // module keys
        'name' => 'roboto 2',               // page title
        'menu' => '',                       // menu name
        'desc' => 'Luring Deskripsi',       // option description 
        'icon' => '',                       // module title
        'caps' => 'read',                   // capabilities
        'node' => 'zera',                   // users | themes | plugins | {$custom_prefix}
        'cell' => 'Karim',                  // sub node name
        'sort' => 50,                       // menu posisition (int)
        'view' => '',                       // layout
        'load' => array(
            'former' =>  'form_1',          // former id
        ), 
    );

    return  $scheme;
}
add_filter( 'register_scheme', 'register_example_system' );

