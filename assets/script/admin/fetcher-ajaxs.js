/***  COREST - AJAXS */

class connex {

    constructor() {

    }

    // fetch
    ajax( model, value, mode ) {

        return new Promise((resolve) => {

            let data = btoa(JSON.stringify(model));
            let http = new XMLHttpRequest();
            http.onreadystatechange = function () 
            {
                if (this.readyState == 4 && this.status == 200) 
                {
                    resolve( JSON.parse( this.response ) ); 
                }
            };
            http.open('POST', rofecth.url , true);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.send( 'action='+rofecth.method+'&token='+rofecth.id+'&model='+data+'&value='+value+'&crypter='+mode);
        });
    }
}
