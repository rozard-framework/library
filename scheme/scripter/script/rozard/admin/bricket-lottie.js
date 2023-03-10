/*jshint esversion: 6 */ 

class lotties{

    constructor() {
        
    }

    // lottie 
    lottie( style, target, src ) {

        // start render element
        let player     = document.querySelector('.'+this.target);
        let container  = document.createElement("div");
        let animater   = document.createElement("lottie-player");

        // clear element to prevent dupilicate render
        player.innerText = '';

        // build lottie element
        animater.setAttribute('src', this.src);
        animater.setAttribute('background', 'transparent');
        animater.setAttribute('speed', '1');
        animater.setAttribute('loop', '');
        animater.setAttribute('autoplay', '');
        container.appendChild(animater);

        // assign lottie element
        container.setAttribute('class', this.style);
        player.appendChild(container);
    }
}