<?php

function example_theme_scheme( $scheme ) {


    $scheme['themes']['structure'] = array(
        'bootups' => array(
            'name'   => 'cuckoo',       // blocks | droper | static
            'model'  => 'static',       // blocks | droper | static
            'menus'  => 4,              // int
            'banner' => true,
        ),
        'support' => array(
            'logo'    => true,         // custom logo for themes
            'html5'   => true,         // html 5 element
            'thumb'   => true,         // post thumbnails
            'menus'   => true,         // custom menu
            'tagline' => true,         // title tag
            'feature' => true,         // post thumnails
            'widget'  => true,         // classic widget
            'block'   => true,         // guttenberg widget
        ),
        'layout' => array(
            'home'      =>  'full',    // full | right-sidebar | left-sidebar | dual-sidebar
            'archive'   =>  'full',    // full | right-sidebar | left-sidebar | dual-sidebar
            'author'    =>  'full',    // full | right-sidebar | left-sidebar | dual-sidebar
            'taxonomy'  =>  'full',    // full | right-sidebar | left-sidebar | dual-sidebar
            'header'    =>  'full',    // full | right-sidebar | left-sidebar | dual-sidebar
            'footer'    =>  'full',    // full | right-sidebar | left-sidebar | dual-sidebar
            'search'    =>  'full',    // full | right-sidebar | left-sidebar | dual-sidebar
            'post'      =>  'full',    // full | right-sidebar | left-sidebar | dual-sidebar
            'page'      =>  'full',    // full | right-sidebar | left-sidebar | dual-sidebar
            'media'     =>  'full',    // full | right-sidebar | left-sidebar | dual-sidebar
            '404'       =>  'full',    // full | right-sidebar | left-sidebar | dual-sidebar
            'footer'    =>   3,        // footer collumns | min 1 max 4               
        ),
        'menu' => array(
            'header' => array(
                'header_top'    => false,
                'header_left'   => false,
                'header_right'  => true,
                'header_bottom' => false,
            ),
            'footer' => array(
                'footer_1' => false,
                'footer_2' => true,
                'footer_3' => false,
                'footer_4' => false,
            ),
            'social' => array(
                'social_1' => true,
            ),
        ),
    );

    /*** FORM - CONFIG THEME */
    $scheme['former']['theme_form'] = array(
        'name' => 'Test Form',      // seting name 
        'icon' => 'Sites 2',        // feature icon
        'desc' => 'Description',    // setting descroption
        'caps' => 'read',
        'data' => 'option',         // site | term | user | post | dbms | option | theme_mod           
        'type' => 'normal',         // normal | submit                
        'mode' => 'plain',           
        'form' => array(
            'group_a' => array(
                'name'  =>  'Theme 1',
                'desc'  =>  'Them Config Group',
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
                        'cond'  => array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'hore' => array(
                        'type'  =>  'textarea',
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
     *  THEMES 
     * 
     *  syntax: 
     *  $scheme[$scheme][$level]
     * 
     *  example:
     *  $scheme['theme']['config']
     *  $scheme['theme']['master']
     * 
     *  @param  $scheme  =  scheme name       
     *  @param  $module  =  module type
     */


     $scheme['theme']['config'][] = array(
        'keys' => 'theme_config',           // setting keys
        'name' => 'Theme Config 1',         // module title
        'desc' => 'Contoh Deskripsi',       // option description 
        'icon' => 'Theme Config 1',         // module title
        'caps' => 'read',                   // capabilities
        'node' => 'appearance',             // none 
        'sort' => 50,                       // posisition (int)
        'form' => 'theme_form',
    );

    $scheme['former']['zaza_form'] = array(
        'name' => 'Test Form',      // seting name 
        'icon' => 'Sites 2',        // feature icon
        'desc' => 'Description',    // setting descroption
        'caps' => 'read',
        'data' => 'option',         // site | term | user | post | dbms | option | theme_mod           
        'type' => 'normal',         // normal | submit                
        'mode' => 'plain',           
        'form' => array(
            'za_a' => array(
                'name'  =>  'Theme 1',
                'desc'  =>  'Them Config Group',
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
                        'cond'  => array(
    
                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'hore' => array(
                        'type'  =>  'textarea',
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
    
    
    $scheme['former']['evi_form'] = array(
        'name' => 'Brand Form',     // seting name 
        'icon' => 'Sites 2',        // feature icon
        'desc' => 'Description',    // setting descroption
        'caps' => 'read',
        'data' => 'option',         // site | term | user | post | dbms | option | theme_mod           
        'type' => 'normal',         // normal | submit                
        'mode' => 'plain',           
        'form' => array(
            'vi_a' => array(
                'name'  =>  'Theme 1',
                'desc'  =>  'Them Config Group',
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
                        'cond'  => array(
    
                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'hore' => array(
                        'type'  =>  'textarea',
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
    
    
    $scheme['themes']['config'][] = array(
        'keys' => 'zaza_config',           // setting keys
        'name' => 'Evi Config 1',         // module title
        'desc' => 'Contoh Deskripsi',       // option description 
        'icon' => 'Theme Config 1',         // module title
        'caps' => 'read',                   // capabilities
        'node' => 'appearance',             // none 
        'sort' => 50,                       // posisition (int)
        'form' => 'zaza_form',
    );
    
    
    $scheme['themes']['config'][] = array(
        'keys' => 'evi_config',           // setting keys
        'name' => 'Karim Config 1',         // module title
        'desc' => 'Contoh Deskripsi',       // option description 
        'icon' => 'Theme Config 1',         // module title
        'caps' => 'read',                   // capabilities
        'node' => 'appearance',             // none 
        'sort' => 50,                       // posisition (int)
        'form' => 'evi_form',
    );



    return $scheme;
}
add_filter( 'register_scheme', 'example_theme_scheme' );