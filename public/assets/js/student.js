const ul_tags = document.querySelector("#information-tags")
const ul_panels = document.querySelector("#information-panels")

ul_tags.addEventListener("click", (e)=>{

    let li_active = ul_tags.querySelector("li.active")
    if(li_active) {
        li_active.classList.remove("active")
    }

    if(e.target.tagName == "LI") {
        e.target.classList.add("active")
        
        let a_tag = e.target.querySelector("a")
        let div_panel = ul_panels.querySelector(`${a_tag.getAttribute("href")}`)
        
        let panel_active = ul_panels.querySelector(".show")
       
        if(panel_active) {
            panel_active.classList.remove("show")
            panel_active.classList.remove("active")
        }
        
        div_panel.classList.add("active")
        div_panel.classList.add("show")


    }
})