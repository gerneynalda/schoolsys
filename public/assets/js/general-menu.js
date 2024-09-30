let generalMenu = document.querySelector("#general-menu")
let generalMenuBtn = document.querySelector("#general-menu-btn")

let isShown = 0
generalMenuBtn.addEventListener("click", (e) => {
    switch(isShown) {
        case 0:

            // is already hidden therefore show the menu
            generalMenu.classList.add('show-general-menu')
            generalMenu.classList.remove('hide-general-menu')

            e.target.classList.add('open-state')
            e.target.classList.remove('close-state')

            isShown = 1
            break;

        case 1:

            // is already shown there hide the menu
            generalMenu.classList.add('hide-general-menu')
            generalMenu.classList.remove('show-general-menu')

            e.target.classList.add('close-state')
            e.target.classList.remove('open-state')

            isShown = 0
            break;

        default:
            
            break;
            
    }
})