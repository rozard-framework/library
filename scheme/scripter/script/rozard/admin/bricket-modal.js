/*jshint esversion: 6 */ 

class modals{

    constructor() {

    }

    // modal
    modal() {

        let actions = Array.prototype.slice.call( document.querySelectorAll('.modal-open') ); 

        if ( actions.length > 0 ) {
    
            actions.forEach( open_modal => {
            
                open_modal.addEventListener( 'click', (event)=> {
    
    
                    let modal  = document.getElementById(event.currentTarget.dataset.target);
                    let close  = modal.querySelector('.btn-clear');
                    let clear  = modal.querySelector('.modal-overlay');
                    
                    // open modal
                    modal.classList.add('active');
    
                    // close modal
                    close.addEventListener('click', ()=> {
                        modal.classList.remove('active');
                    });
    
                    clear.addEventListener('click', ()=> {
                        modal.classList.remove('active');
                    });
                });
            });
        }   
    }
}