let reportCardConfig = new Map()
// DATA
let subjectListData = null
let traitListData = null
let semesterListData = null
let periodListData = null
let monthListData = null

let curriculumSubjectsData = null

// REPORT CARD TEMPLATE
let reportCardTemplateUI = document.querySelector("#report-card-template-list")
let reportCardModalTrigger = document.querySelector("#report-card-template-modal-trigger")
let closeReportCardModalTrigger = document.querySelector("#close-reportcard-template-modal")
let reportCardTemplateInput = document.querySelector("#report-card-template-upload-input")
let saveReportCardTemplateBtn = document.querySelector("#save-reportcard-template")
let searchReportCardTemplateInput = document.querySelector("#search-report-card-template")
let reportCardTemplateData = []

const modalConfig = {
    keyboard: true,
    backdrop: 'static'
}
// Show report card modal
reportCardModalTrigger.addEventListener("click", (e) => {
    // empty file input
    reportCardTemplateInput.value = ""
    $("#report-card-template-modal").modal("show")

})
// Close report card modal
closeReportCardModalTrigger.addEventListener("click", (e)=>{
    $("#report-card-template-modal").modal("hide")
})
// save report card template
saveReportCardTemplateBtn.addEventListener("click", async (e)=>{
    
    let file = new FormData()
    file.append("file", reportCardTemplateInput.files[0])
    let result = await addReportCardTemplate(file)
    if(result.success) {
        // empty input after successfully uploading a file
        reportCardTemplateInput.value = ""
        // update report card template list
        updateReportCardTemplateUI()
        // notify
        addNotificationToQeue("alert-success", result.message)
    }else {
        addNotificationToQeue("alert-danger", result.message)
    }

})
// highlight if clicked
reportCardTemplateUI.addEventListener("click", async (e)=>{
    let active = null
    // add active if click remove active from the rest
    if(e.target.classList.contains("list-group-item")) {

        active = reportCardTemplateUI.querySelector(".list-group-item.active")
        if(active != null) {
            active.classList.remove("active")
        }

        e.target.classList.add("active")
    }
    // delete report card
    if(e.target.classList.contains('delete-report-card')) {

        let confirmed = confirm("Are you sure you want to delete this template?")
        if(confirmed) {

            let data = await deleteReportCardTemplate(e.target.dataset.reportcardid)
            if(data.success) {
                // update list
                updateReportCardTemplateUI()
                // notify
                addNotificationToQeue("alert-success", data.message)
            }else{
                addNotificationToQeue("alert-success", data.message)
            }

        }

    }
})
// Search Template
let timeout
searchReportCardTemplateInput.addEventListener("keyup", (e)=>{
    clearTimeout(timeout)
    timeout = setTimeout(()=>{
        searchReportCardTemplate(e.target.value)
    }, 300)
})
// Update Report Card List
async function updateReportCardTemplateUI()
{
    let templates = await getReportCardTemplates()
    let list = ''
    let dataIndex = 0
    for(let i in templates.data) {
        // add to reportCardTemplateData to be index and used for search function; in lowercase to avoid case sensitivity
        reportCardTemplateData.push(templates.data[i].filename.toLocaleLowerCase())
        list += `<li class="list-group-item" data-index="${dataIndex}" data-reportcardid="${templates.data[i].id}">`;
		list += `${templates.data[i].filename}`
        list += `<div class="btn-group" role="group">`
        list += `<button type="button" class="btn btn-xs btn-default delete-report-card" data-reportcardid="${templates.data[i].id}"><i class="fa-solid fa-trash"></i></button>`
        list += `</div>`
		list += `</li>`
        // increase
        dataIndex++
    }
    reportCardTemplateUI.innerHTML = list
}
// search report card template
function searchReportCardTemplate(name) {

    // transform string case to lower to avoid case sensitivity cause its not a password
    let str = name.toLocaleLowerCase()
    for(let i = 0; i < reportCardTemplateData.length; i++) {
        if(!reportCardTemplateData[i].includes(str)) {
            // display hide the value that does not have the same string as the str
            let element = reportCardTemplateUI.querySelector(`[data-index='${i}']`)
            element.setAttribute("style","display:none;")
        }else{
            // show the value with the same string as the str
            let element = reportCardTemplateUI.querySelector(`[data-index='${i}']`)
            element.setAttribute("style","")
        }
    }
    
}

// CURRICULUMS
let curriculumListUI = document.querySelector("#curriculum-list")
let curriculumData = []

curriculumListUI.addEventListener("click", (e)=>{
    let active = null
    // add active if click remove active from the rest
    if(e.target.classList.contains("list-group-item")) {

        active = curriculumListUI.querySelector(".list-group-item.active")
        if(active != null) {
            active.classList.remove("active")
        }

        e.target.classList.add("active")
    }

})
// update curriculum list ui
async function updateCurriculumUI()
{
    curriculumData = await getCurriculumMasterlist()
    let list = ""
    for(let i in curriculumData.data) {
        list += `<li class="list-group-item" data-id="${curriculumData.data[i].id}">`
        list += `${curriculumData.data[i].name}`
        list += `</li>`
    }
    curriculumListUI.innerHTML = list
}

async function updateCurriculumSubjectsListUI(curriculumid, strandid)
{

    let result = await getCurriculumSubjects(curriculumid, strandid)
    curriculumSubjectList = result.data
    // add subject list as options to selectedSubjectInput element
    let list = '<option value="">Select Subject</option>'
    for(let i in curriculumSubjectList) {
        list += `<option value="${curriculumSubjectList[i].subject_id}">${subjectListData[curriculumSubjectList[i].subject_id].name}</option>`
    }
    selectSubjectInput.innerHTML = list

}

async function updateCurriculumSemesterListUI(curriculumid, strandid)
{

    let result = await getCurriculumSemesters(curriculumid, strandid)
    let list = ''

    if(result.data.length > 0) {

        list = '<option value="">Select Semester</option>'
        for(let i in result.data) {
            list += `<option value="${result.data[i].semester_id}">${semesterListData[result.data[i].semester_id].name}</option>`
        }
        selectSemesterInput.innerHTML = list

    }else {

        list += '<option value="">Select Semester</option>'
        for(let i in semesterListData) {
            list += `<option value="${semesterListData[i].id}">${semesterListData[i].name}</option>`
        }
        selectSemesterInput.innerHTML = list

    }
    
}

async function updateCurriculumTraitsListUI(curriculumid, strandid)
{

    let result = await getCurriculumTraits(curriculumid, strandid)
    let traits = result.data
    // add subject list as options to selectedSubjectInput element
    let list = '<option value="">Select Trait</option>'
    for(let i in traits) {
        list += `<option value="${traits[i].trait_id}">${traitListData[traits[i].trait_id].description}</option>`
    }
    selectTraitInput.innerHTML = list

}


// STRANDS
let strandListUI = document.querySelector("#strand-list")
let strandData = []

strandListUI.addEventListener("click", (e)=>{
    let active = null
    // add active if click remove active from the rest
    if(e.target.classList.contains("list-group-item")) {

        active = strandListUI.querySelector(".list-group-item.active")
        if(active != null) {
            active.classList.remove("active")
        }

        e.target.classList.add("active")
    }

})
// update strand list ui
async function updateStrandUI()
{
    strandData = await getStrandMasterlist()
    let list = ""
    for(let i in strandData.data) {
        list += `<li class="list-group-item" data-id="${strandData.data[i].id}">`
        list += `${strandData.data[i].name}`
        list += `</li>`
    }
    strandListUI.innerHTML = list
}


// SHEETS
let sheetListUI = document.querySelector("#sheet-list")
let addSheetBtn = document.querySelector("#add-sheet")
let sheetTitle = document.querySelector("#configuration-sheet-name")

addSheetBtn.addEventListener("click", (e) => {
    let n = (reportCardConfig.size) + 1
    reportCardConfig.set(`sheet_${n}`, [])
    updateSheetListUI()
})

// update sheet list ui
function updateSheetListUI()
{   
    let list = ""
    let sheetCount = 1
    for(let [key, config] of reportCardConfig) {
        list += `<li class="list-group-item" data-key=${key}> Sheet ${sheetCount}`
        list += `<div class="btn-group" role="group" >
                    <button type="button" class="btn btn-xs btn-default remove-sheet" data-key=${key}><i class="fa-solid fa-trash"></i></button>
                </div>`
        list += `</li>`
        sheetCount++
    }
    sheetListUI.innerHTML = list
}
// 
sheetListUI.addEventListener("click", (e)=>{
    // remove sheet
    if(e.target.classList.contains("remove-sheet")) {

        let msg = ''
        let key = e.target.dataset.key
        let sheetContent = reportCardConfig.get(key)
   
        msg = sheetContent.length > 0 ? "This sheet has configurations, are you sure you want to delete this sheet?" : "Are you sure you want to delete this sheet?"

        let confirmed = confirm(msg)

        if(confirmed) {

            reportCardConfig.delete(key)
            // notify user 
            addNotificationToQeue("alert-warning", "Sheet has been removed. You need to click 'save to db' for the changes to save on the database.")
            // update the sheet list
            updateSheetListUI()
            // update the configuration list
            updateSheetConfigurationUI()

        }
    }

    let active = null
    // add active if click remove active from the rest
    if(e.target.classList.contains("list-group-item")) {

        active = sheetListUI.querySelector(".list-group-item.active")
        if(active != null) {
            active.classList.remove("active")
        }
        e.target.classList.add("active")
        // update sheet name
        sheetTitle.innerHTML = e.target.innerText
        updateSheetConfigurationUI()
    }
})



// CONFIGURATIONS SHEETS
let sheetNameUI = document.querySelector("#configuration-sheet-name")
let configurationUI = document.querySelector("#sheet-configurations")
let selectConfigTypeInput = document.querySelector("#configuration-type")
let selectSubjectInput = document.querySelector("#subject-id")
let selectTraitInput = document.querySelector("#trait-id")
let selectSemesterInput = document.querySelector("#semester-id")
let selectPeriodInput = document.querySelector("#period-id")
let cellCoordinateInput = document.querySelector("#cell-coordinate")
let saveConfig = document.querySelector("#save-config")
let saveConfigToDB = document.querySelector("#save-config-to-database")
let getConfigFromDB = document.querySelector("#get-config-to-database")
let sheetConfigurationUI = document.querySelector("#sheet-configurations")

let subjectFormGroup = document.querySelector(".subject-config")
let traitFormGroup = document.querySelector(".trait-config")
let semesterFormGroup = document.querySelector(".semester-config")
let periodFormGroup = document.querySelector(".period-config")

let schoolyearFormGroup = document.querySelector(".schoolyear-config")
let monthFormGroup = document.querySelector(".month-config")
let attendanceTypeFormGroup = document.querySelector(".attendance-type-config")

let selectSchoolyearInput = document.querySelector("#schoolyear-id")
let selectMonthInput = document.querySelector("#month-id")
let selectAttendanceTypeInput = document.querySelector("#attendance-type")

let allowedOptions = ["subject", "trait"]
selectConfigTypeInput.addEventListener("change", (e) => {

    // get subjects of this curriculumid
    let curriculum = curriculumListUI.querySelector(".list-group-item.active")
    let strand = strandListUI.querySelector(".list-group-item.active")

    // if no curriculum and strand is selected;
    // display a notification and set the selected options to the first option
    if(strand == null || curriculum == null) {
        // notify
        addNotificationToQeue("alert-danger", "Please select a curriculum or a strand.")
        // set to first option
        selectConfigTypeInput.options.selectedIndex = 0
        return false
    }
    // proceed with code below if both are set.
    if(allowedOptions.includes(e.target.value)) {
        semesterFormGroup.setAttribute("style","display:block;")
        periodFormGroup.setAttribute("style","display:block;")
    } else {
        semesterFormGroup.setAttribute("style","display:none;")
        periodFormGroup.setAttribute("style","display:none;")
    }

    switch(e.target.value) {
        case 'subject':
            
            updateCurriculumSubjectsListUI(curriculum.dataset.id, strand.dataset.id)
            updateCurriculumSemesterListUI(curriculum.dataset.id, strand.dataset.id)
            subjectFormGroup.setAttribute("style","display:block;")
            traitFormGroup.setAttribute("style","display:none;")

            schoolyearFormGroup.setAttribute("style","display:none;")
            monthFormGroup.setAttribute("style","display:none;")
            attendanceTypeFormGroup.setAttribute("style","display:none;")
            break;

        case 'trait':
            
            updateCurriculumTraitsListUI(curriculum.dataset.id, strand.dataset.id)
            updateCurriculumSemesterListUI(curriculum.dataset.id, strand.dataset.id)
            subjectFormGroup.setAttribute("style","display:none;")
            traitFormGroup.setAttribute("style","display:block;")

            schoolyearFormGroup.setAttribute("style","display:none;")
            monthFormGroup.setAttribute("style","display:none;")
            attendanceTypeFormGroup.setAttribute("style","display:none;")
            break;

        case 'attendance':

            subjectFormGroup.setAttribute("style","display:none;")
            traitFormGroup.setAttribute("style","display:none;")

            schoolyearFormGroup.setAttribute("style","display:block;")
            monthFormGroup.setAttribute("style","display:block;")
            attendanceTypeFormGroup.setAttribute("style","display:block;")
            break;

        default:
            
            subjectFormGroup.setAttribute("style","display:none;")
            traitFormGroup.setAttribute("style","display:none;")

            schoolyearFormGroup.setAttribute("style","display:none;")
            monthFormGroup.setAttribute("style","display:none;")
            attendanceTypeFormGroup.setAttribute("style","display:none;")
            break;

    }
    
})
saveConfig.addEventListener("click", (e)=>{
    
    let config = {}
    let type = selectConfigTypeInput.value
    // dont proceed with saving if cellCoordinateInput is empty.
    if(cellCoordinateInput.value.length <= 0) {
        addNotificationToQeue("alert-danger", "Please input a cell coordinate.")
        cellCoordinateInput.focus()
        return false
    }

    switch(type) {
        case 'subject':

            config["type"] = type
            config["subject_id"] = selectSubjectInput.value
            config["semester_id"] = selectSemesterInput.value
            config["period_id"] = selectPeriodInput.value
            config["cell_coordinate"] = cellCoordinateInput.value.toUpperCase()
            break;

        case 'trait':

            config["type"] = type
            config["trait_id"] = selectTraitInput.value
            config["semester_id"] = selectSemesterInput.value
            config["period_id"] = selectPeriodInput.value
            config["cell_coordinate"] = cellCoordinateInput.value.toUpperCase()
            break;

        case 'attendance':
            
            config['type']  = type
            config['schooldays_id'] = selectMonthInput.value
            config['attendance_type'] = selectAttendanceTypeInput.value
            config['schoolyear_id'] = selectSchoolyearInput.value
            config['month_name']   = selectMonthInput.selectedOptions[0].text
            config['cell_coordinate'] = cellCoordinateInput.value.toUpperCase()

        default:

            config["type"] = type
            config["cell_coordinate"] = cellCoordinateInput.value.toUpperCase()

    }

    // get the selected sheet
    let selectedSheet = sheetListUI.querySelector(".list-group-item.active")
    if(selectedSheet == null) {
        // if no sheet is selected notify and dont add the configuration
        addNotificationToQeue("alert-danger", "No configuration sheet selected.")
        return false
    }
    // get sheet key
    let sheetKey = selectedSheet.dataset.key
    addConfiguration(sheetKey, config)

})

saveConfigToDB.addEventListener("click", async (e)=>{
    // get configuration and convert it to object
    let config_obj = Object.fromEntries(reportCardConfig)

    // get reportcarttemplate id
    let selectedReportCardTemplate = reportCardTemplateUI.querySelector(".list-group-item.active")

    if(selectedReportCardTemplate == null) {
        addNotificationToQeue("alert-warning", "Please select a report card template.")
        return false
    }
    let reportcardtemplateid = selectedReportCardTemplate.dataset.reportcardid

    // get curriculum id
    let selectedCurriculum = curriculumListUI.querySelector(".list-group-item.active")
    if(selectedCurriculum == null) {
        addNotificationToQeue("alert-warning", "Please select a curriculum.")
        return false
    }
    let curriculumid = selectedCurriculum.dataset.id

    // get strand id
    let selectedStrand = strandListUI.querySelector(".list-group-item.active")
    if(selectedStrand == null) {
        addNotificationToQeue("alert-warning", "Please select a strand.")
        return false
    }
    let strandid = selectedStrand.dataset.id

    

    let result = await saveReportCardConfiguration(reportcardtemplateid, curriculumid, strandid, JSON.stringify(config_obj))
    if(result.success) {

        addNotificationToQeue("alert-success", result.message)

    } else {

        addNotificationToQeue("alert-danger", result.message)

    }
})

getConfigFromDB.addEventListener("click", async (e)=> {
    
    let selectedReportCardTemplate = reportCardTemplateUI.querySelector(".list-group-item.active")
    // get curriculum id
    let selectedCurriculum = curriculumListUI.querySelector(".list-group-item.active")
    // get strand id
    let selectedStrand = strandListUI.querySelector(".list-group-item.active")

    if(selectedCurriculum == null || selectedStrand == null) {
        addNotificationToQeue("alert-danger", "Please select a Report Card Template, Curriculum, and Strand.")
        return false
    }

    let curriculumid = selectedCurriculum.dataset.id
    let strandid = selectedStrand.dataset.id

    let result = await getReportCardConfiguration(curriculumid, strandid)
    let msg = "No configuration has been set."

    if(Object.keys(result.data).length > 0 || result.data.length > 0) {
       
        let configurations = JSON.parse(result.data.configuration) 
        if(Object.keys(configurations).length > 0) {

            reportCardConfig = new Map(Object.entries(configurations))
            updateSheetListUI()
            // select the first sheet
            sheetListUI.children[0].click()
            updateSheetConfigurationUI()
            // set notification message
            msg = "Retrieving configurations."

        }
        
        // notify
        addNotificationToQeue("alert-success", msg)

    }else {
        addNotificationToQeue("alert-success", msg)
        sheetListUI.innerHTML = ""
        sheetConfigurationUI.innerHTML = ""
    }
    
})

sheetConfigurationUI.addEventListener("click", (e) => {
    
    if(e.target.classList.contains("remove-configuration-from-sheet")) {
        
        let confirmed = confirm("Are you sure you want to remove this item from the configuration?")
        if(confirmed) {
            let selectedSheet = sheetListUI.querySelector(".list-group-item.active")
            let sheetKey = selectedSheet.dataset.key
            let config_item_index = e.target.dataset.index
            let configuration = reportCardConfig.get(sheetKey)

            // remove item from config
            configuration.splice(config_item_index, 1)
            // update sheet
            reportCardConfig.set(sheetKey, configuration)
            // update sheeConfigurationUI
            updateSheetConfigurationUI()
            // notify
            addNotificationToQeue("alert-success", "Configuration has been successfully updated.")
        }
    }

})

// query schooldays when schoolyear is changed
selectSchoolyearInput.addEventListener("change", async (e) => {

    let result = await getSchoolyearSchoolDays(e.target.value)

    // add to Month data

    let list = '<option value="">Select Month</option>'

    if(result.success) {

        for(let i in result.data) {
            list += `<option value="${result.data[i].id}">${result.data[i].month}</option>`
        }

        selectMonthInput.innerHTML = list

    } else {

        addNotificationToQeue("alert-warning", result.message)

    }

})

function addConfiguration(sheetKey, config)
{
    let configuration = reportCardConfig.get(sheetKey)
    configuration.push(config)
    reportCardConfig.set(sheetKey, configuration)
    // update UI
    updateSheetConfigurationUI()
    // notify
    addNotificationToQeue("alert-success", "New configuration added")
    // empty cellCoordinateInput after saving config
    cellCoordinateInput.value = ""

}

function updateSheetConfigurationUI()
{
    let selectedSheet = sheetListUI.querySelector(".list-group-item.active")
    let list = ""
    if(selectedSheet != null) {
        // get key
        let sheetKey = selectedSheet.dataset.key
        // get sheet configuration using key
        let configuration = reportCardConfig.get(sheetKey)

        // loop through configuration and display data
        
        for(let i in configuration) {
            
            list += `<li class="list-group-item"><div><i class="fa-solid fa-cog"></i> `
            list += `${configuration[i].type.toUpperCase()} : Cell Coordinate => "${configuration[i].cell_coordinate}"`
            switch(configuration[i].type) {
                case 'subject':
                    list += configuration[i].hasOwnProperty('subject_id') ? `<p class="list-group-item-text text-muted"><i class="fa-solid fa-book"></i> ${subjectListData[configuration[i].subject_id].name}</p>` : ''
                    break
                case 'trait':
                    list += configuration[i].hasOwnProperty('trait_id') ? `<p class="list-group-item-text text-muted"><i class="fa-solid fa-book"></i> ${traitListData[configuration[i].trait_id].description}</p>` : ''
                    break
                case 'attendance':
                    list += `<p class="list-group-item-text text-muted" >${configuration[i].month_name} : ${configuration[i].attendance_type.replace("_"," ").toUpperCase()}</p>`
                default:
                    break
            }

            list += `</div>`
            list += `<div class="btn-group" role="group">
                        <button type="button" class="btn btn-default btn-sm remove-configuration-from-sheet" data-index=${i}><i class="fa-solid fa-trash"></i></button>
                    </div>`
            list += `</li>`
        }
    }
    sheetConfigurationUI.innerHTML = list
}


// On windows load
window.addEventListener("load", async (e)=>{

    $("#report-card-template-modal").modal(modalConfig)

    // list all curriculum on load
    updateCurriculumUI()
    // list all strand on load
    updateStrandUI()
    // list all report card templates on load
    updateReportCardTemplateUI()

    // get data list
    let subjects = await getSubjectMasterList()
    subjectListData = subjects.data

    let traits = await getTraitMasterList()
    traitListData = traits.data

    let list =''
    // add semester list as options to selecteSemesterInput element
    result = await getSemesterMasterlist()
    semesterListData = result.data
    list += '<option value="">Select Semester</option>'
    for(let i in semesterListData) {
        list += `<option value="${semesterListData[i].id}">${semesterListData[i].name}</option>`
    }
    selectSemesterInput.innerHTML = list
    list = ''

    // add period list as options to selectePeriodInput element
    result = await getPeriodMasterlist()
    periodListData = result.data
    list += '<option value="">Select Period</option>'
    for(let i in periodListData) {
        list += `<option value="${periodListData[i].id}">${periodListData[i].name}</option>`
    }
    selectPeriodInput.innerHTML = list
    list = ''
})

