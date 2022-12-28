
/***  CORES */
class core {

    constructor() {}

    body_unscroll() {
        document.getElementsByTagName("BODY")[0].classList.add('no-scroll');
    }

    body_scroll() {
        document.getElementsByTagName("BODY")[0].classList.remove('no-scroll');
    }

    /** COLOR */
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

    /** ELEMENT */
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

    rep_ids ( old_id, new_id ) {
        this.get_ids(old_id ).setAttribute('id', new_id);
    }

    clone ( content, target,id ) {
        const node = document.querySelector(content);
        const clone = node.cloneNode(true);
        clone.setAttribute('id', id);
        node.remove();
        document.querySelector(target).appendChild(clone);
      
    }

    /** ELEMENT */
    new_html( element, target, text, id  ) {
        const para = document.createElement(element);
        para.setAttribute( 'id',  id );
        para.innerText = text;
        target.appendChild(para);
    }

    /** LOTTIE */
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

    /** SANITIZER */
    str_slug( data ) {
        let string =  (data).toString().toLowerCase().replace(/\s+/g, '-').replace(/[^\u0100-\uFFFF\w\-]/g,'-').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
        return string;
    }


    /** VALIDATION */
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
