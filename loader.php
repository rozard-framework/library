<?php


/**
 *  ROZARD - WP FRAMEWORK
 *  @author Al Muhdil Karim
 *  @dedicated for my beloved parent
 */



declare(strict_types=1);


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


	require_once rozard . 'auxile/_init.php';
	

/** MODULE */

	function import_module( $package ) {

		
		// static module
		if( ! isset( $_SESSION[ 'auxile_load' ] ) ) {
			$_SESSION['auxile_load'] = 1;
			require_once rozard . 'auxile/_init.php';
			require_once rozard . 'packer/_init.php';
		}


		// dynamic module
		if ( ! isset( $_SESSION[ 'fetchs_load' ] ) && in_array( 'fetchs', $package )  ) {
			$_SESSION['fetchs_load'] = 1;
			require_once rozard . 'fetchs/_init.php';
		}


		if ( ! isset( $_SESSION[ 'former_load' ] ) && in_array( 'former', $package )  ) {
			$_SESSION['former_load'] = 1;
			require_once rozard . 'former/_init.php';
		}


		if ( ! isset( $_SESSION[ 'layout_load' ] ) && in_array( 'layout', $package ) ) {
			$_SESSION['layout_load'] = 1;
			require_once rozard . 'layout/_init.php';
		}


		if ( ! isset( $_SESSION[ 'module_load' ] ) && in_array( 'module', $package )  ) {
			$_SESSION['module_load'] = 1;
			require_once rozard . 'module/_init.php';
		}

		
		if (  ! isset( $_SESSION[ 'vendor_load' ] ) && in_array( 'vendor', $package ) ) {
			$_SESSION['vendor_load'] = 1;
			require_once rozard . 'vendor/_init.php';
		}
	}