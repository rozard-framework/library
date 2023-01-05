<?php 


declare(strict_types=1);
if ( ! defined('ABSPATH') || ! defined('WP_LIBRARY')  || ! defined( 'rozard' ) ){ exit; }



/*** ROZARD SCHEME */


    function get_cores() {
        $based = (object) array(
            'assets' => array(
                'styles' => array(
                    'admin' => array(
                        'link' => admin_url('library/assets/styles/admin/'),
                        'path' => ABSPATH . 'wp-admin/library/assets/styles/admin/',
                    ),
                    'public' => array(
                        'path' => ABSPATH . 'wp-content/library/script/',
                        'link' => content_url('library/script/'),
                    ),
                ),
                'script' => array(
                    'admin' => array(
                        'path' => ABSPATH . 'wp-admin/library/assets/script/admin/',
                        'link' => admin_url('library/assets/script/admin/'),
                    ),
                    'public' => array(
                        'path' => ABSPATH . 'wp-content/extend/styles/',
                        'link' => content_url('extend/styles/'),
                    ),
                ),
                'images' => array(
                    'admin' => array(
                        'path' => ABSPATH . 'wp-admin/library/assets/images/admin/',
                        'link' => admin_url('library/assets/images/admin/'),
                    ),
                    'public' => array(
                        'path' => ABSPATH . 'wp-content/extend/images/',
                        'link' => content_url('extend/images/'),
                    ),
                ),
                'vendor' => array(
                    'admin' => array(
                        'path' => ABSPATH . 'wp-admin/library/vendor/',
                        'link' => admin_url('library/vendor/'),
                    ),
                    'public' => array(
                        'path' => ABSPATH . 'wp-content/extend/vendor/',
                        'link' => content_url('extend/vendor/'),
                    ),
                ),
                'animax' => array(
                    'admin' => array(
                        'path' => ABSPATH . 'wp-admin/library/animax/',
                        'link' => admin_url('library/animax/'),
                    ),
                    'public' => array(
                        'path' => ABSPATH . 'wp-content/extend/animax/',
                        'link' => content_url('extend/animax/'),
                    ),
                )
            ),
            'master' => array(
                'datums' => dirname( rozard , 1) . '/rozard-datums' ,
                'packer' => dirname( rozard , 1) . '/rozard-module' ,
                'themes' => ABSPATH .'wp-admin/themes/',
                'admins' => ABSPATH .'wp-admin/extend/',
                'helper' => ABSPATH .'wp-admin/extend/helper/',
                'public' => ABSPATH .'wp-content/extend/',
            ),
            'asyncs' => array(
                'admins-script' => array(
                    'src' => rozard . 'assets/script/admin',
                    'des' => ABSPATH .'wp-admin/extend/script',
                ),
                'admins-styles' => array(
                    'src' => rozard . 'assets/styles/admin',
                    'des' => ABSPATH .'wp-admin/extend/styles',
                ),
                'admins-vendor' => array(
                    'src' => rozard . 'vendor/',
                    'des' => ABSPATH .'wp-admin/extend/vendor',
                ),
                'admins-images' => array(
                    'src' => rozard . 'assets/images/admin',
                    'des' => ABSPATH .'wp-admin/extend/images',
                ),
                'admins-animax' => array(
                    'src' => rozard . 'assets/animax/admin',
                    'des' => ABSPATH .'wp-admin/extend/animax',
                ),
                'public-script' => array(
                    'src' => rozard . 'assets/script/public',
                    'des' => ABSPATH .'wp-content/extend/script',
                ),
                'public-styles' => array(
                    'src' => rozard . 'assets/styles/public',
                    'des' => ABSPATH .'wp-content/extend/styles',
                ),
                'public-vendor' => array(
                    'src' => rozard . 'vendor',
                    'des' => ABSPATH .'wp-content/extend/vendor',
                ),
                'public-images' => array(
                    'src' => rozard . 'assets/images/public',
                    'des' => ABSPATH .'wp-content/extend/images',
                ),
                'public-animax' => array(
                    'src' => rozard . 'assets/animax/public',
                    'des' => ABSPATH .'wp-content/extend/animax',
                ),
            ),
            'credit' => array(
                'developer' => array(
                    'name' => 'Al Muhdil Karim',
                    'blog' => 'https://almuhdilkarim.com/',
                ),
                'company' => array(
                    'name'    => 'Lektor Media Utama',
                    'webs'    => 'https://lectore.com',
                    'logo'    =>  content_url() . '/extend/images/main-logo.webp',
                    'address' => 'Tokopedia Tower 22nd Floor Unit F, JL. Prof. DR. Satrio KAV. 11, Jakarta, ID',
                ),
                'statement' => array(
                    'credit' => 'Al Muhdil Karim &#169 2019 - '. date('Y'),
                    'legals' => 'All other trademarks and copyrights are the property of their respective owners. All rights reserved.',
                ),
            ),
        );
        return $based;
    }


    function get_stack() {
        $stacks = array(
            'asiste' => array( 
                'cleaner',
                'convert',
                'crypter',
                'develop',
                'filedir',
                'general',
                'getters',
                'validat',
            ),
            'docust' => array(),
            // 'datums' => array( 'loader' ),
            'fetchs' => array(),
            'fields' => array( 'loader' ),
            'kernel' => array(
                'modprobe',
                'performs',
                'scripter',
                'security',
            ),
            // 'layout' => array( 'loader' ),
            // 'models' => array( 'loader' ),
            'packer' => array( 
                'object' => array(

                ),
                'partial' => array(
                ),
                // 'loader',
            ),
            'panels' => array( 
                // 'resyncs',
                // 'updates' 
            ),
            'rebase' => array(
                'primer' => array(
                    // 'flushers', 
                    // 'layouter', 
                    // 'profiles',
                    // 'rebrands',
                ),
                // 'loader'
            ),
            'vendor' => array(
                'devels' => array(
                    'tester',
                    // 'helper',
                    // 'drafts',
                ),
            ),
        );
        return $stacks;    
    }


