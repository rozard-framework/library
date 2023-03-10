<?php

trait rozard_builder_field_switch{


    public function switch() {
        
        $swtich = sprintf( '<label class="toggle"><input class="toggle-checkbox" type="checkbox" %s><div class="toggle-switch"></div><span class="toggle-label">%s</span></label>',
                        'checked',
                        'Label'
                    );
    }

}


