<?php


if ( ! class_exists( 'rozard_auxile_loader' ) ) {

    class rozard_auxil_loader {


        public function __construct() {
            $this->defs();
        }


        private function defs() {
            define( 'rozard_auxile', __DIR__ .'/' );
            $this->load();
        }


        private function load() {
            $this->core();
            $this->mods();
            $this->part();
        }


        private function core() {
            require_once rozard_auxile . 'method/auxiler.php';
            require_once rozard_auxile . 'method/cleaner.php';
            require_once rozard_auxile . 'method/convert.php';
            require_once rozard_auxile . 'method/crypter.php';
            require_once rozard_auxile . 'method/develop.php';
            require_once rozard_auxile . 'method/filedir.php';
            require_once rozard_auxile . 'method/getters.php';
            require_once rozard_auxile . 'method/validat.php';
        }


        private function mods() {
            // require_once rozard_auxile . 'rebased/appmode.php';
            // require_once rozard_auxile . 'rebased/manages.php';
        }


        private function part() { 
            // require_once rozard_auxile . 'partials/general.php';
            // require_once rozard_auxile . 'partials/avatar.php';
        }
    }
    new rozard_auxil_loader;
}


