let schoolyearList = document.querySelector("#schoolyear-list")
let selectedSchoolyear = {
    id: "",
    description:""
}
let currentSchoolyearName = document.querySelector("#current-selected-schoolyear-name")

let addSchoolDaysBtn = document.querySelector("#add-schooldays-btn")
let noOfDaysInput = document.querySelector("#no-of-days")
let monthInput = document.querySelector("#month-selected")

let schoolyearsSchooldaysList = document.querySelector("#schoolyears-schooldays")
let schoolyearsSchooldaysData = []

let saveSchoolDaysBtn = document.querySelector("#save-schooldays-btn")

let loader = document.querySelector("#loader")

// When click retrieve the schooldays associated to this schoolyear form the databse
schoolyearList.addEventListener("click", async (e) => {

    if(e.target.classList.contains('list-group-item')) {

        // show loader
        loader.setAttribute("style","display:flex;")

        let el = schoolyearList.querySelector(".list-group-item.active")
        if(el != null) {
            el.classList.remove('active')
        }
        e.target.classList.add('active')

        selectedSchoolyear.id = e.target.dataset.id
        selectedSchoolyear.description = e.target.dataset.description

        currentSchoolyearName.innerHTML = `School Year ${selectedSchoolyear.description} School Days`

        let schooldayList = await getSchoolyearSchoolDays(selectedSchoolyear.id)
        schoolyearsSchooldaysData = schooldayList.data
        updateSchoolyearsSchooldaysList()
        
        // hide loader
        loader.setAttribute("style", "display:none;")
    }

})

// when clicked add a schooldays to a schoolyear which will then be listed on the side panel
addSchoolDaysBtn.addEventListener("click", (e)=>{
    addSchoolDays()
})
noOfDaysInput.addEventListener("keyup", (e)=>{

    if(e.target.classList.contains('form-control') && (e.key === 'Enter' || e.keyCode === 13)) {
        addSchoolDays()
    }

})

// Save schooldays
saveSchoolDaysBtn.addEventListener("click", async (e) => {

    // show loader
    loader.setAttribute("style","display:flex;")

    if(schoolyearsSchooldaysData.length <= 0) {

        addNotificationToQeue("alert-warning", "Please add school days to this school year.")
        // hide loader
        loader.setAttribute("style","display:none;")
        return false

    }

    // prevent unintended saving of school days in a school year
    let confirmed = confirm("Are you sure you want to save this school days in this school year?")

    if(!confirmed) {
        // hide loader
        loader.setAttribute("style","display:none;")
        return false
    }else {
         // hide loader
         loader.setAttribute("style","display:none;")
    }

    let result = await saveSchoolyearSchoolDays(schoolyearsSchooldaysData)

    if(result.success) {

        addNotificationToQeue("alert-success", result.message)
        let insertedData = await getSchoolyearSchoolDays(selectedSchoolyear.id)
        schoolyearsSchooldaysData = insertedData.data
        updateSchoolyearsSchooldaysList()


    } else {

        addNotificationToQeue("alert-warning", result.message)

    }

    // hide loader
    loader.setAttribute("style","display:none;")
})

// 
schoolyearsSchooldaysList.addEventListener('click', async (e)=>{

    if(e.target.classList.contains('edit-schoolday')) {

        let id  = e.target.dataset.id
        let input = schoolyearsSchooldaysList.querySelector(`#data_${id}`)

        if(input.value.length <= 0) 
        {
            addNotificationToQeue("alert-warning", "Please fill out the no of school days.")
            return false
        }

        let result = await saveNoOfDays(id, input.value)

        if(result.success) {

            addNotificationToQeue("alert-success", result.message)

        } else {

            addNotificationToQeue("alert-warning", result.message)

        }

    }

    if(e.target.classList.contains('delete-schoolday')) {

        let id = e.target.dataset.id

        let confirmed = confirm("Are you sure you want to delete this record?")

        if(confirmed) {

            let result = await deleteSchooldayRecord(id)

            if(result.success) {

                addNotificationToQeue("alert-success", result.message)
                let insertedData = await getSchoolyearSchoolDays(selectedSchoolyear.id)
                schoolyearsSchooldaysData = insertedData.data
                updateSchoolyearsSchooldaysList()
    
            } else {
    
                addNotificationToQeue("alert-warning", result.message)
    
            }

        }
    }

})


// Function add schooldays
function addSchoolDays()
{
    let month = monthInput.value
    let no_of_days = noOfDaysInput.value

    // loop to check if there are duplicates
    let alreadyIncluded = false
    for(let i in schoolyearsSchooldaysData) {
        if(schoolyearsSchooldaysData[i].month == month && schoolyearsSchooldaysData[i].schoolyear_id == selectedSchoolyear.id) {
            alreadyIncluded = true
            break
        }
    }

    if(!alreadyIncluded ) {

        if(selectedSchoolyear.id.length > 0 && month.length > 0 && no_of_days.length > 0) {

            schoolyearsSchooldaysData.push({
                id: "",
                month: month,
                no_of_days: no_of_days,
                schoolyear_id: selectedSchoolyear.id
            })

        } else {

            addNotificationToQeue("alert-danger","Please select a school year, month, and no. of days.")

        }
        
    }

    updateSchoolyearsSchooldaysList()
}

// Function to update the list of school days in a year
function updateSchoolyearsSchooldaysList()
{
    let list = ''

    // loop through 
    for(let i in schoolyearsSchooldaysData) {
        list += `<li class="list-group-item">
						<div class="input-group">
							<span class="input-group-addon">${schoolyearsSchooldaysData[i].month.substring(0, 3)}</span>
							<input type="text" class="form-control" id="data_${schoolyearsSchooldaysData[i].id}" aria-describedby="basic-addon3" value="${schoolyearsSchooldaysData[i].no_of_days}">
						</div>
						<div class="btn-group">
							<button class="btn btn-default btn-sm edit-schoolday" data-id="${schoolyearsSchooldaysData[i].id}"><i class="fa-solid fa-edit"></i></button>
							<button class="btn btn-default btn-sm delete-schoolday" data-id="${schoolyearsSchooldaysData[i].id}"><i class="fa-solid fa-trash"></i></button>
						</div>
					</li>`
    }

    schoolyearsSchooldaysList.innerHTML = list
}