/*jshint esversion: 6 */ 

class steps {

    constructor() {

    }

    // steps
    steps() {

        let steps = Array.prototype.slice.call(document.querySelectorAll('.step-layout'));
       
        steps.forEach( step => {

            let actions = Array.prototype.slice.call(step.querySelectorAll('.step-action'));
            let items   = Array.prototype.slice.call(step.querySelectorAll('.step-item'));
            let tabs    = Array.prototype.slice.call(step.querySelectorAll('.step-content'));

            actions.forEach( action => {
                action.addEventListener('click', (event)=> {

                    items.forEach( item => {
                        item.classList.remove('active');

                    });

                    tabs.forEach( tab => {
                        tab.classList.remove('active');
                    });

                    document.getElementById( event.currentTarget.dataset.step ).classList.add('active');
                    document.getElementById( event.currentTarget.dataset.tabs ).classList.add('active');
                });
            });
            
        });
    }
}