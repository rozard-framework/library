<?php


/**
 *  ROZARD - WP FRAMEWORK
 *  @author Al Muhdil Karim
 *  @dedicated for my beloved parent
 */




/*** HEADS */

	declare(strict_types=1);




/*** CHMOD */

	define( 'FS_METHOD', 'direct');
	define( 'FS_CHMOD_DIR',  0755 );
	define( 'FS_CHMOD_FILE', 0644 );




/*** MAIN */

	define( 'rozard', __DIR__ . '/' );
	define( 'rozard_version' , '2.0.2' );




/*** DEVEL */

	define( 'rozard_sands', true );
	define( 'rozard_labor', true );
	define( 'rozard_docus', true );
	define( 'QM_SHOW_ALL_HOOKS', true );
	define( 'QM_ENABLE_CAPS_PANEL', false );
	define( 'QM_DISABLED', false );




/*** ASISTE LIBRARIES */

	require_once rozard . 'asiste/auxiler.php';
	require_once rozard . 'asiste/cleaner.php';
	require_once rozard . 'asiste/convert.php';
	require_once rozard . 'asiste/crypter.php';
	require_once rozard . 'asiste/develop.php';
	require_once rozard . 'asiste/filedir.php';
	require_once rozard . 'asiste/getters.php';
	require_once rozard . 'asiste/validat.php';



	
/*** INPUTS LIBRARIES */
	require_once rozard . 'inputs/forms/init.php';



/** LAYOUTS LIBRARIES */

	require_once rozard . 'layout/renders.php';
