<?php

function register_script_scheme( $scheme ) {

    
    $scheme['script']['front'][] = array(
        'type'  => 'css',               // css  | js
        'node'  => 'theme',             // plugin | theme
        'hook'  => 'head',              // head | foot
        'caps'  => 'read',              // script capability
        'base'  => 'cuckoo',            // plugin / theme directory name
        'name'  => 'ipmi-main',        // script handle name 
        'file'  => 'main',              // script file name 
        'load'  => '',                  // load filter, post_type
        'deps'  =>  array(),            // script dependencies
        'vers'  => 1,                   // script version
        'args'  => 'all',               // for css is media type | for js is true or false ( Whether to enqueue the script before </body> instead of in the <head>. )
    );


    $scheme['script']['front'][] = array(
        'type'  => 'jsx',               // css  | js
        'node'  => 'theme',             // plugin | theme
        'hook'  => 'head',              // head | foot
        'caps'  => 'read',              // script capability
        'base'  => 'cuckoo',            // plugin / theme directory name
        'name'  => 'ipmi-main',        // script handle name 
        'file'  => 'main',              // script file name  
        'load'  => '',                  // load filter, post_type            
        'deps'  =>  array(),            // script dependencies
        'vers'  => 1,                   // script version
        'args'  => 'all',               // for css is media type | for js is true or false ( Whether to enqueue the script before </body> instead of in the <head>. )
    );

    return $scheme;
}
add_filter( 'register_scheme', 'register_script_scheme' );