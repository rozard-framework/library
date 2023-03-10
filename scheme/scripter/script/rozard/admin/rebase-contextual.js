/***  MODS - HELPER */
class contextual {

    constructor() {
        this.core = new core;
        this.prepare();
    }


    prepare_header() {
        let $ = this.core;
        let heading = $.get_cls('.contextual-help-tabs');
        const icons  = document.createElement("i");
        const title  = document.createElement("h1");
        const header = document.createElement("div");
        header.setAttribute('id', 'contextual-header');
        heading.appendChild(header);
        icons.classList.add('las', 'la-atom');
        header.appendChild(icons);
        title.innerText = 'Blitz Menu';
        header.appendChild(title);
    }


    prepare_button() {
        let $ = this.core;
        let button =  $.get_ids('context-action');
        const open = document.createElement("i");
        open.classList.add('action-icon');
        open.classList.add('las', 'la-atom');
        button.appendChild(open);

        let exit =  $.get_ids('tab-link-close-contextual');
        exit.innerText = '';
        const close = document.createElement("i");
        close.classList.add('action-icon');
        close.classList.add('las', 'la-times-circle');
        exit.appendChild(close);
    }
 

    prepare() {
        let $ = this.core;
        $.rep_ids('screen-meta',  'context-overlay');
        $.rep_ids('screen-meta-links',  'context-action');
        $.get_ids('contextual-help-wrap').classList.remove('hidden');
        $.get_ids('contextual-help-link-wrap').remove();
        $.get_cls('.contextual-help-sidebar').remove();
        $.get_ids('contextual-help-back').remove();
       
        let screen_opt =  $.get_ids( 'screen-options-wrap');
        if ( screen_opt !== null ) {
            screen_opt.classList.remove('hidden');
        }
       
        this.prepare_header();
        this.prepare_button();

        this.methods();
        this.feature();
    }


    methods() {
        let $ = this.core;

        // open method
        $.get_ids('context-action').addEventListener( 'click', ()=> {
            $.get_cls('.help-tab-content').classList.add('active');
            $.get_ids('tab-panel-close-contextual').classList.remove('active');
            $.get_ids('contextual-help-wrap').classList.toggle('show');
        });

        // close method
        $.get_ids('tab-link-close-contextual').addEventListener( 'click', (event)=> {
            $.get_ids('contextual-help-wrap').classList.remove('show');
        });

        // lottie method
        this.feature;
    }

    
    feature() {

        let $ = this.core;

        $.get_ids('context-action').addEventListener('click', ()=> {
            if ( $.get_ids('animator-options').childNodes.length < 1) { // Or just `if (element.childNodes.length)`
                $.lottie_local('ninja-options.json', $.get_ids('animator-options') );
            }
        })

        $.get_ids('tab-link-core-manage').addEventListener('click', ()=> {
            if ( $.get_ids('animator-manage').childNodes.length < 1) {
                $.lottie_local('ninja-manage.json', $.get_ids('animator-manage') );
            }
        })

        $.get_ids('tab-link-core-wizard').addEventListener('click', ()=> {
            if ( $.get_ids('animator-wizard').childNodes.length < 1) {
                $.lottie_local('ninja-wizard.json', $.get_ids('animator-wizard') );
            }
        })

        $.get_ids('tab-link-core-setting').addEventListener('click', ()=> {
            if ( $.get_ids('animator-setting').childNodes.length < 1) {
                $.lottie_local('ninja-setting.json', $.get_ids('animator-setting') );
            }
        })
    }
}

window.addEventListener("load", () => {
    new contextual;
});