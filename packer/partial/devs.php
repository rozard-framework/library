<?php


if (! class_exists( 'rozard_devel' ) ) {


    class rozard_devel extends cores {

        public $dev_hooks = array();
        public $dev_local = array();



        public function __construct() {
            add_action('current_screen', [$this, 'register_context' ] );
        }


        /*** DEVELOPER HELPER */
        public function register_context() {

            $screen = get_current_screen(); 

            // REGISTER CONTEXT
            $screen->add_help_tab(  
                array( 
                    'id'       => 'developer_context', 
                    'title'	   => __('Developer'), 
                    'content'  => null, 
                    'callback' => array( $this, 'render_context' ), 
                )
            );


            // DEFAULT HOOKS
            $this->devel_hook( '', 'All', 'Current Screen', $screen->id );
            $this->devel_hook( '', 'All', 'Current Uri', $this->get_page_link() );
        }


        public function render_context() {

            echo  '<div class="panel context">';
            echo     '<div class="panel-header d-flex">';
            echo        '<figure class="avatar avatar-lg"><img src="'.rzd_url .'assets/image/backend/avatar-2.png" alt="Avatar"></figure>';
            echo         '<div>';
            echo              '<div class="panel-title h5 mt-10">Developer Assistant</div>';
            echo              '<div class="panel-subtitle">Building code like a writing poetry</div>';
            echo         '</div>';
            echo         '<div class="panel-nav">';
            echo            '<ul class="tab tab-block">';
            echo             '<li class="tab-item active" data-target="developer-hook" data-parent="context-devel">';
            echo                 '<a id="devel-hooks-action" href="#" class="badge" data-badge="0">Hooks</a>';
            echo             '</li>';
            echo             '<li class="tab-item" data-target="developer-local" data-parent="context-devel">';
            echo                 '<a href="#" class="badge" data-badge="0">Localize</a>';
            echo             '</li>';
            echo             '<li  class="tab-item" data-target="developer-notif" data-parent="context-devel" >';
            echo                 '<a id="devel-notif-action" href="#" class="badge" data-badge="0">Error</a>';
            echo             '</li>';
            echo            '</ul>';
            echo         '</div>';
            echo     '</div>';
            echo     '<div class="panel-body context-devel">';
            echo         '<div id="developer-hook" class="tab-content active">';
                            $this->context_hooks();
            echo         '</div>';
            echo         '<div id="developer-local" class="tab-content">';
                            $this->context_local();
            echo         '</div>';
            echo         '<div id="developer-notif" class="tab-content">';
                            $this->context_notif();
            echo         '</div>';
            echo     '</div>';
            echo     '<div class="panel-footer">';
            echo         '<!-- buttons or inputs -->';
            echo     '</div>';
            echo  '</div>';

        }
     

        private function context_hooks() {
          
            $data = $this->dev_hooks;

            $screen = get_current_screen(); 

            echo '<table class="table table-striped table-hove">';
                echo '<thead>';
                    echo '<tr>';
                        echo '<th> Module </th>';
                        echo '<th> Scope </th>';
                        echo '<th> Value </th>';
                    echo '</tr>';
                echo '</thead>';
                echo '<tbody id="context-devel-table-hooks">';
                foreach( $this->dev_hooks as $key => $master ) {
                    if ( empty( $master['screen'] ) || ( ! empty( $master['screen'] ) && $master['screen'] === $screen->id  ) ) 
                    {
                        echo '<tr class="">';
                         echo '<td>'.$master['module'].'</td>';
                        echo '<td>'.$master['scope'].'</td>';
                        echo '<td>'.$master['unique'].'</td>';
                        echo '</tr>';
                    }
                }
                echo '</tbody>';
            echo '</table>';
        }


        private function context_notif() {
            echo '<table class="table table-striped table-hove">';
                echo '<thead>';
                    echo '<tr>';
                        echo '<th> Module </th>';
                        echo '<th> Function </th>';
                        echo '<th> Unique </th>';
                        echo '<th> Description </th>';
                    echo '</tr>';
                echo '</thead>';
                echo '<tbody id="context-devel-table-notif">';
                echo '</tbody>';
            echo '</table>';
        }


        private function context_local() {

        }


        /*** DEVELOPER METHOD */
        public function devel_hook(  $screen, $module, $scope, $value ) {

            $error = array(
                'screen'   => $screen,
                'module'   => $module,
                'scope'    => $scope,
                'unique'   => $value,
            );
            array_push( $this->dev_hooks, $error );
        }


    }

    new rozard_devel;
}

