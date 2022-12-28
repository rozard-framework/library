class proto_tabs{

    constructor() {
        $ = new core;
        let actions = $.get_all('.tab-action');
        actions.forEach(action => {
            action.addEventListener('click', (event)=> {

                let parent = $.get_ids( event.currentTarget.dataset.parent) ;
                let target = parent.querySelector('#'+event.currentTarget.dataset.target);
                let closes = Array.prototype.slice.call( parent.querySelectorAll('.tab-content') );

                closes.forEach( close => {
                    close.classList.remove('active');
                });
                target.classList.add('active');
            })
        });
    }
}

window.addEventListener("load", () => {
    new proto_tabs;
});