<?php


/**
 *  ROZARD - Wordpress Developement Framework
 *  @author Al Muhdil Karim
 *  @dedicated for my beloved parent
 */


declare(strict_types=1);



if ( ! class_exists( 'rozard' ) ) {

	// config
	require_once 'config.php';


	// master
	class rozard{


		public function __construct() {
			$this->grub();
		}


		public function grub() {
			$this->kernel();
			$this->packer();
			$this->scheme();
		}


		private function kernel() {
			require_once rozard . 'kernels/_runit.php';
			new rozard_kernels;
 		}


		private function packer() {
			require_once rozard . 'packers/_runit.php';
			new rozard_packers;
		}


		private function scheme() {
			require_once rozard . 'scheme/_runit.php';
			new rozard_scheme;
		}
	}


	// hooker
	function wp_includes() {
		new rozard; 
	}
}