<?php


function object_test_scheme(   $scheme ) {

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
    

    /**
     *  COREST 
     * 
     *  syntax: 
     *  $scheme[$scheme][$level]
     * 
     *  example:
     *  $scheme['corest']['post']
     *  $scheme['corest']['term']
     *  $scheme['corest']['mbox']
     * 
     *  @param  $scheme  =  scheme name       
     *  @param  $module  =  module type  -  post | term | mbox
     */


    /**  POST  */
    $scheme['object']['post'][] = array(
        'keys'   =>  'archive',             // post slug
        'name'   =>  'Archive',             // post name
        'desc'   =>  'Archive Description', // post description
        'icon'   =>  '',                    // menu icon
        'node'   =>  'website',             // website | {$custom_prefix}       
        'leed'   =>  20,                    // execerpt lenght
        'mode'   =>  'web',                 // sys | app | web
        'caps'   =>  'post',                // post | custom
        'edit'   =>  'classic',             // classic | guttenberg
        'more'   =>  '',                    // read more | html
        'menu'   =>  false,                 // true | false
        'level'  =>  false,                 // set true for hierarchy model
        'modul'  =>  array(),               // post module 
        'format' =>  array(),               // format support
    );



    $scheme['object']['post'][] = array(
        'keys'   =>  'news',                // post slug
        'name'   =>  'News',                // post name
        'desc'   =>  'News Description',    // post description
        'icon'   =>  '',                    // menu icon
        'node'   =>  'website',             // website | {$custom_prefix}    
        'leed'   =>  20,                    // execerpt lenght
        'mode'   =>  'web',                 // sys | app | web
        'caps'   =>  'post',                // post | custom
        'edit'   =>  'guttenberg',          // classic | guttenberg
        'more'   =>  '',                    // read more | html
        'menu'   =>  false,                 // true | false
        'level'  =>  false,                 // set true for hierarchy model
        'modul'  =>  array(),               // post module 
        'format' =>  array(),               // format support
    );



    $scheme['object']['post'][] = array(
        'keys'   =>  'Book',              // post slug
        'name'   =>  'Book',              // post name
        'desc'   =>  'Book Description',  // post description
        'icon'   =>  'dashicons-cart',    // menu icon
        'node'   =>  'product',           // website | {$custom_prefix}     
        'leed'   =>  20,                  // execerpt lenght
        'mode'   =>  'web',               // sys | app | web
        'caps'   =>  'post',              // post | custom
        'edit'   =>  'classic',           // classic | guttenberg
        'more'   =>  '',                  // read more | html
        'menu'   =>  true,                // true | false
        'level'  =>  false,               // set true for hierarchy model
        'modul'  =>  array(),             // post module 
        'format' =>  array(),             // format support
    );



    $scheme['object']['post'][] = array(
        'keys'   =>  'case',                // post slug
        'name'   =>  'case',                // post name
        'desc'   =>  'case Description',    // post description
        'icon'   =>  '',                    // menu icon
        'node'   =>  'product',             // website | {$custom_prefix}         
        'leed'   =>  20,                    // execerpt lenght
        'mode'   =>  'web',                 // sys | app | web
        'caps'   =>  'post',                // post | custom
        'edit'   =>  'classic',             // classic | guttenberg
        'more'   =>  '',                    // read more | html
        'menu'   =>  false,                 // true | false
        'level'  =>  false,                 // set true for hierarchy model
        'modul'  =>  array(),               // post module 
        'format' =>  array(),               // format support
    );



    /**  TERM  */
    $scheme['object']['term'][] = array(
        'keys'   =>  'address',                     // term slug
        'name'   =>  'Address',                     // term name
        'desc'   =>  'Address Description',         // term description
        'icon'   =>  '',                            // menu icon
        'built'  =>  'Karim',                       // default term
        'mode'   =>  'web',                         // sys | app | web
        'caps'   =>  'read',                        // post | custom
        'hook'   =>  array( 'post' ),               // post type slug
        'form'   =>  'test_1',                   // former id
        'level'  =>  false,                         // set true for hierarchy model
        
    );



    $scheme['object']['term'][] = array(
        'keys'   =>  'venue',                       // term slug
        'name'   =>  'Venue',                       // term name
        'desc'   =>  'Venue Description',           // term description
        'icon'   =>  '',                            // menu icon
        'built'  =>  'Mercure',                     // default term
        'mode'   =>  'web',                         // sys | app | web
        'caps'   =>  'read',                        // post | custom
        'hook'   =>  array( 'post', 'single-archive' ),    // post type slug
        'form'   =>  '',                            // former id
        'level'  =>  false,                         // set true for hierarchy model
    );


    /**  BOXS  */
    $scheme['object']['boxs'][] = array(
        'keys' => 'box_1',                  // module title
        'name' => 'Box 1',                  // module title
        'caps' => 'read',                   // capabilities
        'node' => 'attachment',             // post_type |  screen id
        'part' => 'normal',                 // header  | advanced  | normal 
        'sort' => 'high',                   // 'high'  | 'core' | 'default' | 'low'
        'load' => array(
            array(
                'former' => 'test_1',       // form id
            )
        )
    );


    $scheme['object']['boxs'][] = array(
        'keys' => 'box_2',                  // module title
        'name' => 'Box 2',                  // module title
        'caps' => 'read',                   // capabilities
        'node' => 'website-archive',        // post_type |  screen id
        'part' => 'normal',                 // header  | advanced  | normal 
        'sort' => 'default',                // 'high'  | 'core' | 'default' | 'low'
        'load' => array(
            array(
                'former' => 'test_1',       // form id
            )
        )
    );

    return $scheme;
}
add_filter('register_scheme', 'object_test_scheme');