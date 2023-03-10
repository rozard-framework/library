
class proto_taxopost{
    constructor() {
        $ = new core;
        let inits = $.get_all( '.droping' );
        inits.forEach(init => {
            init.addEventListener('click', (event)=> {
                let parent = event.currentTarget.parentNode.parentNode;
                parent.classList.toggle('active');
            });
        });
    }
}

window.addEventListener("load", () => {
    new proto_taxopost;
});