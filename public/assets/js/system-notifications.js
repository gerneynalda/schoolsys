let systemNotificationListUI = document.querySelector("#system-notifications-wrapper")
let notificationLimit = 3

// insert notification in the systemNotificationListUI
function addNotificationToQeue(type, message) {

    // addNotificationToQeue("alert-success","Test message to be removed");
    systemNotificationListUI.insertAdjacentHTML("beforeend", `<div class="alert ${type}" style="opacity:0.7;"><i class="fa-solid fa-note-sticky"></i> <strong>${message}</strong></div>`)
    removeNotificationFromQeue()
}
// remove notification from the systemNotificationListUI
function removeNotificationFromQeue() {

    // get all alert elements in systemNotificationListUI
    let elements = systemNotificationListUI.querySelectorAll(".alert")
    // remove the first notification which has 0 index only if there are notification element inside
    if(elements.length >= 1) {

        if(elements.length > 3) {
      
            // remove immediately if more than 3
            elements[0].remove()
            removeNotificationFromQeue()
            
        }else{
            
            setTimeout(()=>{
                elements[0].remove()
                removeNotificationFromQeue()
            },1800)

        }
    }
    
}