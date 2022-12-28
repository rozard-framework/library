/***  MASTER - SIGN / NOTICE */
class rebase_notice{

    constructor() {
        this.assist = new core;
        this.temporer();
    }

    
    temporer() {
        let devnotes = this.assist.get_all( '.notice-temporer' );
        devnotes.forEach( note => {
            setTimeout( ()=> {
                note.style.animation = "fade_out 300ms";
                setTimeout( ()=> {
                    note.remove();
                }, 250);
            }, 5000);
        })
    }
}


window.addEventListener("load", () => {
    new rebase_notice;
});