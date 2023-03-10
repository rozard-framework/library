<?php


/*** MAIN */

    define( 'rozard', __DIR__ . '/' );
    define( 'rozard_version' , '2.0.2' );



    /*** CORES */ 


    define( 'DISALLOW_FILE_EDIT', false );
    define( 'DISALLOW_FILE_MODS', false );
    define( 'DISABLE_WP_CRON', true);
    define( 'AUTOSAVE_INTERVAL', 300); // seconds
    define( 'WP_POST_REVISIONS', false);
    define( 'WP_MEMORY_LIMIT', '512M' );
    define( 'WP_MAX_MEMORY_LIMIT', '512M');
    define( 'WP_CACHE', true);



/*** CHMOD */


    define( 'FS_METHOD', 'direct');
    define( 'FS_CHMOD_DIR',  0755 );
    define( 'FS_CHMOD_FILE', 0644 );



/*** DEVEL */


    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true );
    define( 'WP_DEBUG_DISPLAY', true );
    define( 'SCRIPT_DEBUG', true );
    define( 'QM_SHOW_ALL_HOOKS', true );
    define( 'QM_ENABLE_CAPS_PANEL', false );
    define( 'QM_DISABLED', false );
    define( 'QM_HIDE_SELF', false );
    define( 'rozard_sands', true );
    define( 'rozard_labor', true );
    define( 'rozard_docus', true );