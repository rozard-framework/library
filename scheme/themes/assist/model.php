<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

/** 
 *  DEFAULT THEMES 
 *  SCHEME MODEL 
 * 
 * */







function rozard_theme_config( $scheme ) {

    /** BRAND ID */

    $scheme['former']['brand_id'] = array(
        'name' => 'Brand Info',     // seting name 
        'icon' => '',               // feature icon
        'desc' => 'Description',    // setting descroption
        'caps' => 'edit_theme_options',
        'data' => 'option',         // site | term | user | post | dbms | option | theme_mod           
        'type' => 'normal',         // normal | submit                
        'mode' => 'plain',           
        'form' => array(
            'brand_info' => array(
                'name'  =>  'Information',
                'desc'  =>  'Brand basic information.',
                'icon'  =>  '',        // feature icon
                'caps'  =>  'edit_theme_options',
                'cond'  =>  array(

                ),
                'field' => array(
                    'nm' => array(
                        'type'  =>  'text',
                        'keys'  =>  'nm',
                        'name'  =>  'Title',
                        'desc'  =>  'Text description',
                        'caps'  =>  'edit_theme_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ),
                    'of' => array(
                        'type'  =>  'textarea',
                        'keys'  =>  'of',
                        'name'  =>  'Address',
                        'desc'  =>  'Facebook fanpage',
                        'caps'  =>  'edit_theme_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  => array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'cp' => array(
                        'type'  =>  'textarea',
                        'keys'  =>  'cp',
                        'name'  =>  'Description',
                        'desc'  =>  'Text description',
                        'caps'  =>  'edit_theme_options',
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
            'brand_contact' => array(
                'name'  =>  'Contact',
                'desc'  =>  'Your institution contact.',
                'icon'  =>  '',        // feature icon
                'caps'  =>  'edit_theme_options',
                'cond'  =>  array(

                ),
                'field' => array(
                    'tl' => array(
                        'type'  =>  'tel',
                        'keys'  =>  'tl',
                        'name'  =>  'Telephone',
                        'desc'  =>  'Text description',
                        'caps'  =>  'edit_theme_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'fx' => array(
                        'type'  =>  'tel',
                        'keys'  =>  'fx',
                        'name'  =>  'Faximile',
                        'desc'  =>  'Text description',
                        'caps'  =>  'edit_theme_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'ml' => array(
                        'type'  =>  'email',
                        'keys'  =>  'ml',
                        'name'  =>  'Email',
                        'desc'  =>  'Text description',
                        'caps'  =>  'edit_theme_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'wa' => array(
                        'type'  =>  'tel',
                        'keys'  =>  'wa',
                        'name'  =>  'Whatsapp',
                        'desc'  =>  'Text description',
                        'caps'  =>  'edit_theme_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ),
                    'tg' => array(
                        'type'  =>  'text',
                        'keys'  =>  'tg',
                        'name'  =>  'Telegram',
                        'desc'  =>  'Text description',
                        'caps'  =>  'edit_theme_options',
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
            'brand_social' => array(
                'name'  =>  'Social Media',
                'desc'  =>  'Your social media url.',
                'icon'  =>  '',        // feature icon
                'caps'  =>  'edit_theme_options',
                'cond'  =>  array(

                ),
                'field' => array(
                    'fb' => array(
                        'type'  =>  'url',
                        'keys'  =>  'fb',
                        'name'  =>  'Facebook',
                        'desc'  =>  'Facebook fanpage',
                        'caps'  =>  'edit_theme_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  => array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'ig' => array(
                        'type'  =>  'url',
                        'keys'  =>  'ig',
                        'name'  =>  'Instagram',
                        'desc'  =>  'Text description',
                        'caps'  =>  'edit_theme_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'lk' => array(
                        'type'  =>  'url',
                        'keys'  =>  'lk',
                        'name'  =>  'Linkedin',
                        'desc'  =>  'Text description',
                        'caps'  =>  'edit_theme_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'yt' => array(
                        'type'  =>  'url',
                        'keys'  =>  'yt',
                        'name'  =>  'Youtube',
                        'desc'  =>  'Text description',
                        'caps'  =>  'edit_theme_options',
                        'cols'  =>  100,
                        'cryp'  =>  false,
                        'cond'  =>  array(

                        ),
                        'attr'  =>  array(
                            'placeholder' => 'insert text please',
                            'require'     => true,
                        ),
                    ), 
                    'tw' => array(
                        'type'  =>  'url',
                        'keys'  =>  'tw',
                        'name'  =>  'Twitter',
                        'desc'  =>  'Text description',
                        'caps'  =>  'edit_theme_options',
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
        'keys' => 'brand_config',           // setting keys
        'name' => 'Brand Identity',         // module title
        'desc' => 'Fill with your brand identity',       // option description 
        'icon' => '',                       // module title
        'caps' => 'edit_theme_options',     // capabilities
        'node' => 'appearance',             // none 
        'sort' => 50,                       // posisition (int)
        'form' => 'brand_id',
    );

    
    return $scheme;
}
add_filter( 'register_scheme', 'rozard_theme_config' );



  

