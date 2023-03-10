<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

  

if ( ! trait_exists( 'rozard_datum_filesys' ) ) {


    trait rozard_datum_filesys{


        function mk_fil( string $target ) {

            if ( ! is_admin() ) { return; }

            if ( ! file_exists( $target ) ) {
                $rzd_file = fopen( $target  , "w") or die ("Unable to open  '. $target  .' !");
                fclose($rzd_file);
            } else {
                dev('file "'. $target .'" is existed.' );
                return;
            }
        }


        function cp_fil( string $source, string $target ) {

            if ( ! is_admin() ) { return; }

            if ( file_exists( $target ) ) {
                dev('file "'. $source .'" is exist on directory '. $target );
                return;
            }

            if ( ! file_exists( $source ) ) {
                dev('file "'. $source .'" not exist' );
                return;
            }


            if ( file_exists( $source ) && ! file_exists( $target ) ) {
                copy($source, $target_path );
            }
        }


        function rm_fil( string $target ) {

            if ( ! is_admin() ) { return; }

            if ( ! file_exists( $target ) ) {
                dev('file "'. $target .'" not exist on directory '. $target );
                return;
            }

            if (!unlink($target)) {
                dev( 'file "'. $target .'"cannot be deleted due to an error.' );
            }
            else {
                dev ( $target . 'has been deleted');
            }
        }


        function mk_dir( string $target, string $chmod, string $chown, string $chgroup ) {

            if ( ! is_admin() ) { return; }

            require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
            require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

            $create = new WP_Filesystem_Direct('direct');

            if ( file_exists( $target ) && is_dir( $target ) ) {
                dev('Directory "'. $target .'" existed. ' );
                return false ;
            }
            $create->mkdir( $target, $chmod, $chown, $chgroup );  
            return true;
        }


        function mkdir( string $path ) {
                
            // requirement
            require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
            require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

            // directories
            $dir = new WP_Filesystem_Direct('direct');
            $dir->mkdir( $path );
        }


        function cp_dir( string $source, string $target ){ 
            

            if ( ! is_admin() ) { return; }

            if ( !  gets_user_role( array( 'administrator' ) )  ) {
                return;
            }

            if ( file_exists( $target ) ) {
                dev('file "'. $source .'" is exist on directory '. $target );
                return false;
            }

            if ( ! file_exists( $source ) ) {
                dev('file "'. $source .'" not exist' );
                return false ;
            }
            

            $srcdir  = opendir($source);                                               // open the source directory
            @mkdir($target); 


            while( $file = readdir($srcdir) ) {                                       // Recursively calling custom copy function for sub directory 
                if (( $file != '.' ) && ( $file != '..' )) { 
                    if ( is_dir($source . '/' . $file) ) { 
                        cp_dir($source . '/' . $file, $target . '/' . $file); // Recursively calling custom copy function for sub directory 
                    }  else { 
                        copy($source . '/' . $file, $target . '/' . $file); 
                    } 
                } 
            } 
            closedir($srcdir);
            return true;
        } 


        function rm_dir( string $target, bool $recursive, string $type ) {
            
            if ( ! is_admin() ) { return; }

            $remove = new WP_Filesystem_Direct('direct');
            $remove->delete( $target, $recursive, $type );  
        }
    }
}