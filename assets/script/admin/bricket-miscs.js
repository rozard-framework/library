/*jshint esversion: 6 */ 

class render_chips{


    constructor() {

    }

    chips() {
        
        // template
        let becolor = this.core.color('dark');
        const chips = document.createElement("div");
        const bulps = document.createElement("p");
        const title = document.createElement("p");
        const close = document.createElement("a");
       
        // main chip element 
        chips.classList.add('chip');
        chips.setAttribute( 'style', 'background-color:'+becolor+';' );

        // title chip element 
        title.classList.add('title');
        title.innerText = this.datas;

        // bulp chip element 
        bulps.classList.add('bulp');
        bulps.innerText = title.innerText .charAt(0);
        
        // button chip close 
        close.classList.add('btn', 'btn-clear' );
        close.dataset.id = this.keys;
        close.setAttribute('aria-label', 'Close"');
        close.setAttribute('role', 'button"');

        // generate element
        chips.appendChild(bulps);
        chips.appendChild(title);
        chips.appendChild(close);
        this.target.appendChild(chips);

        // remove chipst init
        this.remove_chips( this.target );
    }


    remove_chips( parent ) {
        let chips = Array.prototype.slice.call( parent.querySelectorAll('.chip') );
        chips.forEach( chip => { 
            let action = chip.querySelector('.btn-clear');
            action.addEventListener( 'click', ()=> {
                chip.remove();
            }); 
        });
    }
}


class render_default{
    constructor() {

        this.core = new rozard;
    }

    create( payload ) {

        this.keys   = payload['keys'];
        this.datas  = payload['data'];
        this.purges = payload['purge'];
        this.target = document.getElementById(payload['target']);
        this.layout = payload['render'];
        this.class  = payload['class'];
       
        // open target element
        if ( ! this.target.classList.contains('active') ) {
            this.target.classList.add('active')
        }

        // render layout by model selection
        if ( this.layout === 'chips' ) {
            this.chips();
        } else {
            this.default();
        }
    }


    default() {
        // clean data
        this.target.innerText = '';

        this.datas.forEach( data => {
            
            const para = document.createElement("p");
          
            // assigned class
            if ( this.class !== null ) {
                para.classList.add( this.class );
            }

            // assigned data
            if ( data[1] !== null  ) {
                para.innerText = data[1] ;
            } else {
                para.innerText = data;
            }

            // render layout
            this.target.appendChild(para);

            // init destroyer
            this.remove_default();
        }) 
    }


    remove_default() {

        if ( this.purges === 'true' ) {
            let actions = Array.prototype.slice.call( this.target.querySelectorAll( '.'+this.class ) );
            actions.forEach( action => {
                action.addEventListener('click', ()=> {
                    this.target.innerText = '';
                    this.target.classList.remove('active');
                });
            })
        }
    }
}
