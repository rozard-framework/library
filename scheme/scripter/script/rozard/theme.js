
/***  CORE MODULE */

class core {

        
    constructor() {}


    // scroll
    body_unscroll() {
        document.getElementsByTagName("BODY")[0].classList.add('no-scroll');
    }

    body_scroll() {
        document.getElementsByTagName("BODY")[0].classList.remove('no-scroll');
    }


    // color
    color( mode ) {
        if ( mode === 'dark' ) {
            return "#" + ("00000" + Math.floor(Math.random() * Math.pow(16, 6)).toString(16)).slice(-6);
        } else {
            let color = "#";
            for (let i = 0; i < 3; i++)
                color += ("0" + Math.floor(Math.random() * Math.pow(16, 2) / 2).toString(16)).slice(-2);
            return color;
        }
    }


    // getter
    get_all( data ) {
        let protos = Array.prototype.slice.call( document.querySelectorAll( data ));
        return protos;
    }

    get_cls( data ) {
        return document.querySelector( data );
    }

    get_ids(  id ) {
    return document.getElementById(id);
    }

    

    // element 
    rep_ids ( old_id, new_id ) {
        this.get_ids( old_id ).setAttribute('id', new_id);
    }

    clone ( content, target,id ) {
        const node = document.querySelector(content);
        const clone = node.cloneNode(true);
        clone.setAttribute('id', id);
        node.remove();
        document.querySelector(target).appendChild(clone);
    
    }

    new_html( element, target, text, id  ) {
        const para = document.createElement(element);
        para.setAttribute( 'id',  id );
        para.innerText = text;
        target.appendChild(para);
    }



    // lotie
    lottie_local( file, target ) {
        let links = window.location.origin+'/wp-admin/library/features/'+file;
        this.lottie_render( links, target );
    }

    lottie_render( url, target ) {
        const para = document.createElement('lottie-player');
        para.classList.add( 'animator' );
        para.setAttribute( 'src', url );
        para.setAttribute( 'background', 'transparent' );
        para.setAttribute( 'speed', 1 );
        para.setAttribute( 'loop', ''  );
        para.setAttribute( 'autoplay', ''  );
        target.appendChild(para);
    }


    // sanitize
    str_slug( data ) {
        let string =  (data).toString().toLowerCase().replace(/\s+/g, '-').replace(/[^\u0100-\uFFFF\w\-]/g,'-').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
        return string;
    }


    // tabs


    // validation
    elm_check( data ) {
        let element = document.querySelector( data );
        if ( element === null  ) {
            console.log( element+ ' not found, operation aborted.');
            return false;
        } else {
            return true;
        }
    }
}


/***  TABSE MODULE */


class tabs{

    constructor( data ) {

        this.parent = document.querySelector( '.'+data );
        
        if ( this.parent === null  ) {
            return;
        }

        this.actions = Array.prototype.slice.call( this.parent.querySelectorAll( '.action' )); 
        this.content = Array.prototype.slice.call( this.parent.querySelectorAll( '.content' )); 
        this.open();
    }

    open() {
        this.actions.forEach( action => {
            action.addEventListener( 'click', (event)=> {
                let target = this.parent.querySelector('#'+event.currentTarget.dataset.target);
                this.close();
                target.classList.add('active');
                event.currentTarget.classList.add('active');              
            });
        });
    }

    close() {
        this.content.forEach( content => {
            content.classList.remove('active');
        });
        this.actions.forEach( action => {
            action.classList.remove('active');
        });
    }
}


/***  MODULE LOADER */

    window.addEventListener( 'load', ()=> {

        // aos init
        AOS.init();

    });