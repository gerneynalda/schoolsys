let generalMenu = document.querySelector("#general-menu")
let generalMenuBtn = document.querySelector("#general-menu-btn")
let mainWrapper = document.querySelector("#main-wrapper")

let isShown = 0
generalMenuBtn.addEventListener("click", (e) => {
    switch(isShown) {
        case 0:

            generalMenu.classList.add('show-text')
            mainWrapper.classList.add('show-nav-text')
            isShown = 1
            break;

        case 1:

            generalMenu.classList.remove('show-text')
            mainWrapper.classList.remove('show-nav-text')
            isShown = 0
            break;

        default:
            
            break;
            
    }
})