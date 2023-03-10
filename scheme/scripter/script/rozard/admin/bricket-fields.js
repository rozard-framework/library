/*jshint esversion: 6 */ 

/***  FIELDS */
class upload {

    constructor() {

        this.upload();
        
    }

    // UPLOAD FIELD
    upload() {

        let action = Array.prototype.slice.call( document.querySelectorAll('.field-upload') )

        action.forEach( parent => {
    
            let storage = parent.querySelector('.value');
            let upload  = parent.querySelector('.upload');
            let remove  = parent.querySelector('.remove');
            let preview = parent.querySelector('.preview');
            let boxicon = parent.querySelector('.avatar');
            let present = parent.querySelector('.avatar-presence');
            let subtile = parent.querySelector('.tile-subtitle'); 
         

            if ( storage.value.length > 2 ) {
                boxicon.classList.remove('bg-error');
                boxicon.classList.add('bg-primary');
                present.classList.remove('bg-warning');
                present.classList.add('bg-success');
            }

            upload.addEventListener( 'click', (event) => {
    
                let rozard_upload;
                let mime   = storage.dataset.mime;
                let title  = 'Upload '+mime.replace('-',' ');
                  
                if ( rozard_upload ) {
                    rozard_upload.open();
                    return;
                }
    
                rozard_upload  = wp.media.frames.file_frame = wp.media({
                    frame: 'select',
                    title: title[0].toUpperCase() + title.slice(1).toLowerCase(),
                    button: {
                        text: 'Choose',
                    },
                    library: {
                        type: mime 
                    },
                    multiple: false
                });
    
                rozard_upload.on( 'select', function() {
                    let attachment = rozard_upload.state().get('selection').first().toJSON();
                    boxicon.classList.remove('bg-error');
                    boxicon.classList.add('bg-primary');
                    present.classList.remove('bg-warning');
                    present.classList.add('bg-success');
                    subtile.innerText = attachment.url;
                    preview.classList.remove('hide');
                    preview.dataset.url = attachment.url;
                    remove.classList.remove('hide');
                    storage.value = attachment.url;
                    upload.innerText = 'Change';
                    parent = undefined;
                } );
    
                //Open the uploader dialog
                rozard_upload.open();
            });
    
    
            remove.addEventListener( 'click', (event) => {
                boxicon.classList.add('bg-error');
                boxicon.classList.remove('bg-primary');
                present.classList.add('bg-warning');
                present.classList.remove('bg-success');
                subtile.innerText = 'No media upload yet';
                preview.classList.add('hide');
                preview.dataset.url = '';
                remove.classList.add('hide');
                upload.innerHTML = 'Upload';
                storage.value = '';
            });
        });
    }
}


class wpcore {

    constructor() {
        this.model = new models();
        this.conex = new connex();
        this.wpcore();

        
    }

    // CORES FIELD
    wpcore() {
        let corest = Array.prototype.slice.call(document.querySelectorAll('.field-cores'));
        
        corest.forEach( core => {
            let action = core.querySelector('#search-cores');
            action.addEventListener('keyup', async (event) => {
                let value  = event.currentTarget.value; 
                let model  = event.currentTarget.dataset.model;
                let option = core.querySelector('.options');
                let layer  = core.querySelector('.overlay');
                if ( value.length > 3 ) {
                    let request = await this.conex.ajax( model, value, rofecth.crypto );
                    if ( request !== 'empty-data' ) {
                        layer.classList.add('active');
                        option.innerText = '';
                        this.core_method( request, option, action, core, layer );
                    }
                }
            });
        }); 
    }

    core_method( request, option, action, core, layer) {

        let values = core.querySelector('.value');

        request.forEach( result => {
            const para = document.createElement("li");
            para.innerText = result[1];
            para.setAttribute('data-value', result[0] );
            para.classList.add('cores-items');
            option.appendChild(para);

            let selectings =  Array.prototype.slice.call(option.querySelectorAll('.cores-items'));
            selectings.forEach( select => {
                select.addEventListener('click', (event)=> {
                    // close option
                    layer.classList.remove('active');
                    // set value and render chips
                    let label = event.currentTarget.textContent;

                    if ( action.getAttribute('multiple') === 'false' ) 
                    {
                        action.value = '';
                        action.value = label;
                        values.value = event.currentTarget.dataset.value;
                    } 
                    else if ( action.getAttribute('multiple') === 'true' && values.value.length == 0 ) 
                    {
                        // set value and render choosen item
                        values.value = event.currentTarget.dataset.value;
                        this.core_render( values.value, label, core );
                    }
                    else if ( action.getAttribute('multiple') )
                    {
                        let current_value = event.currentTarget.dataset.value;
                        let value_before  = values.value;
                        let array_values  = value_before.split(",");

                        if ( array_values.includes(current_value) !== true )  
                        {
                            values.value = value_before+','+current_value;
                            this.core_render(current_value, label, core );
                        }
                    }
                    option.innerText = '';
                });
            })
        })
    }

    core_render( keys, label, core ){

        let data = {
            keys   : keys,
            data   : label,
            purge  : false,
            target : 'choosen',
            render : 'chips',
            class  : 'chip',
        }
        this.model.create(data);     
        
        // remove init
        this.core_remove(core);
    }

    core_remove(core) {

        let chips = Array.prototype.slice.call(core.querySelectorAll('.btn-clear')) 
        chips.forEach( chip => {
            chip.addEventListener('click', () => {

                // reasign value after delete action
                let value_element = core.querySelector('.value');
                let delete_value  = chip.dataset.id;
                let current_value = value_element.value;
                let array_values  = current_value.split(",");

                array_values.forEach( function (value, i) {
                    if ( value === delete_value ) {
                        array_values.splice(i,1);
                    }
                })

                value_element.value = array_values;
            })
        })
    }
}


class search {

    constructor() {
        
        // method
        this.conex = new connex();
        this.model = new models();
        this.notif = new notif();

        // property
        this.parent;
        this.refers;
        this.result;
        
        this.runits();
    }

    // search
    runits() {

        let actions = Array.prototype.slice.call(document.querySelectorAll('.field-search'));

        if ( actions.length > 0 ) {

            actions.forEach( action => {

                let input  = action.querySelector('.form-input');
                let button = action.querySelector('.search-btn');
                let model  = input.dataset.model;
                this.parent  = action;
                this.refers  = input;
               
                if ( button === null ) {

                    input.addEventListener('keydown', async (event)=> {

                        if ( event.currentTarget.value.length > 1 ) {
                            let request = await this.conex.ajax( model, event.currentTarget.value, rofecth.crypto );
                            this.result = request;
                            this.render();
                        }
                    })

                } else {

                    input.addEventListener("keydown", (event)=> {
                        if (event.keyCode === 13) {
                            button.click();
                        }
                    });

                    button.addEventListener( 'click', async () => {
                        let value   = input.value;
                        let request = await this.conex.ajax( model, value, rofecth.crypto );
                        this.result  = request;
                        this.render();
                    });
                }
            })
        }
    }


    render(){

        // debug data
        console.table(this.result);

       // data render
        let render = {
            target : this.refers.dataset.target,
            render : this.refers.dataset.render,
            purge  : this.refers.dataset.purge,
            class  : this.refers.dataset.class,
            data   : this.result,
        }

        // check output element
        let check = document.getElementById( this.refers.dataset.target );

        // begin render result
        if ( check === null  ) {
            const para = document.createElement("div");
            para.setAttribute('id', this.refers.dataset.target );
            this.parent.appendChild(para);
            this.model.create( render )
        } else {
            this.model.create( render )
        }
      
    }
}