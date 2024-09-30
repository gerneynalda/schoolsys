// CURRICULUM OPERATIONS
let curriculumListUI = document.querySelector("#curriculum-list-group")
let createCurriculumModalTrigger = document.querySelector("#create-curriculum-modal-trigger")
let closeCurriculumModalTrigger = document.querySelector("#close-curriculum-modal")
let curriculumNameInputField = document.querySelector("#curriculum-name-input")
let curriculumSaveButton = document.querySelector("#curriculum-save-button")
let curriculumListData = []
let curriculumData = {
    "id" : "",
    "name" : ""
}


let modalConfig = {
    keyboard: true,
    backdrop: 'static'
}

// Update curriculumListUI
async function updateCurriculumListUI() {
    // get curriculumMasterList
    let result = await getCurriculumMasterlist()
    curriculumListData = result.data

    // prepare list
    let list = '';
    for(let index in curriculumListData) {
        list += `<li class="list-group-item" data-selectcurriculumid="${curriculumListData[index].id}">
            ${curriculumListData[index].name}
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-xs edit-curriculum" data-curriculumname='${curriculumListData[index].name}' data-curriculumeditid=${curriculumListData[index].id}><i class="fa-solid fa-edit"></i></button>
                <button type="button" class="btn btn-default btn-xs delete-curriculum" data-curriculumdeleteid=${curriculumListData[index].id}><i class="fa-solid fa-trash"></i></button>
            </div>
        </li>`
    }
    // update UI
    curriculumListUI.innerHTML = list
}
createCurriculumModalTrigger.addEventListener("click", () => {

    // clear curriculumNameInputField and focus on the field
    curriculumNameInputField.value = ""
    // clear curriculumData
    curriculumData.id = ""
    curriculumData.name = ""
    $("#curriculum-create-edit-modal").modal('show')

})
closeCurriculumModalTrigger.addEventListener("click", () => {

    $("#curriculum-create-edit-modal").modal('hide')

})
curriculumSaveButton.addEventListener("click", async (e) => {

    // if curriculumData.id is empty its a create function
    if(curriculumData.id == "") {
        
        let name = curriculumNameInputField.value

        if(name.trim().length <= 0) {

            addNotificationToQeue("alert-warning", "Please input the name of this curriculum.")
            curriculumNameInputField.focus()
            return false
        }
            
        let data = await createCurriculum(name.trim())
        if(data.success) {
            // update ui
            updateCurriculumListUI()
            // empty the field and focus
            curriculumNameInputField.value = ""
            curriculumNameInputField.focus()
            // notify
            addNotificationToQeue("alert-success", data.message)
        }else {
            // notify
            addNotificationToQeue("alert-success", data.message)
        }

    }
    // if curriculumData.id is not empty its a edit function
    if(curriculumData.id !== "") {

        let name = curriculumNameInputField.value
        
        if(name.trim().length <= 0) {

            addNotificationToQeue("alert-warning", "Please input the name of this curriculum.")
            curriculumNameInputField.focus()
            return false
        }

        curriculumData.name = name
        let data = await updateCurriculum(curriculumData.id, curriculumData.name)
        if(data.success) {
             // update ui
             updateCurriculumListUI()
            //  focus on the field
            curriculumNameInputField.focus()
             // notify
             addNotificationToQeue("alert-success", data.message)
        }else {
            // notify
            addNotificationToQeue("alert-danger", data.message)
        }
    }

})
curriculumListUI.addEventListener("click", async (e) => {

    if(e.target.classList.contains('list-group-item')) {
        let el = curriculumListUI.querySelector('.list-group-item.active')

        let id = e.target.dataset.selectcurriculumid
        selectedCurriculum.id = id
        selectedCurriculum.name = e.target.innerText
        // update curriculumContentsUI
        updateCurriculumContents()

        if(el) {
            el.classList.remove('active')
        }
        e.target.classList.add('active')
    }
    // open curriculum-create-edit-modal
    if(e.target.classList.contains('edit-curriculum')) {

        curriculumData.id = e.target.dataset.curriculumeditid
        curriculumNameInputField.value = e.target.dataset.curriculumname
        $("#curriculum-create-edit-modal").modal('show')

    }
    // delete operation
    if(e.target.classList.contains('delete-curriculum')) {

        let confirmed = confirm("Are you sure you want to delete this curriculum?")
        if(confirmed) {
            let id = e.target.dataset.curriculumdeleteid
            let data = await deleteCurriculum(id)
            if(data.success) {
                // update ui
                updateCurriculumListUI()
                // notify
                addNotificationToQeue("alert-success", data.message)
           }else {
               // notify
               addNotificationToQeue("alert-danger", data.message)
           }
        }
    }

})

// STRAND OPERATIONS
let strandListUI = document.querySelector("#strand-list-group")
let createStrandModalTrigger = document.querySelector("#create-strand-modal-trigger")
let closeStrandModalTrigger = document.querySelector("#close-strand-modal")
let strandNameInputField = document.querySelector("#strand-name-input")
let strandSaveButton = document.querySelector("#strand-save-button")
let strandListData = []
let strandData = {
    "id" : "",
    "name" : ""
}

// Update curriculumListUI
async function updateStrandListUI() {
    // get strandMasterList
    let result = await getStrandMasterlist()
    strandListData = result.data

    // prepare list
    let list = '';
    for(let index in strandListData) {
        list += `<li class="list-group-item" data-selectstrandid="${strandListData[index].id}">
            ${strandListData[index].name}
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-xs edit-strand" data-strandname='${strandListData[index].name}' data-strandeditid=${strandListData[index].id}><i class="fa-solid fa-edit"></i></button>
                <button type="button" class="btn btn-default btn-xs delete-strand" data-stranddeleteid=${strandListData[index].id}><i class="fa-solid fa-trash"></i></button>
            </div>
        </li>`
    }
    // update UI
    strandListUI.innerHTML = list
}
createStrandModalTrigger.addEventListener("click", () => {

    // clear strandNameInputField
    strandNameInputField.value = ""
    // clear strandData
    strandData.id = ""
    strandData.name = ""
    $("#strand-create-edit-modal").modal('show')

})
closeStrandModalTrigger.addEventListener("click", () => {

    $("#strand-create-edit-modal").modal('hide')

})
strandSaveButton.addEventListener("click", async (e) => {

    // if strandData.id is empty its a create function
    if(strandData.id == "") {
        
        let name = strandNameInputField.value

        if(name.trim().length <= 0) {
            addNotificationToQeue("alert-warning", "Please input the name of the strand.")
            strandNameInputField.focus()
            return false
        }

        let data = await createStrand(name.trim())
        if(data.success) {
            // update ui
            updateStrandListUI()
            // notify
            addNotificationToQeue("alert-success", data.message)
        }else {
            // notify
            addNotificationToQeue("alert-success", data.message)
        }

    }
    // if strandData.id is not empty its a edit function
    if(strandData.id !== "") {

        let name = strandNameInputField.value

        if(name.trim().length <= 0) {
            addNotificationToQeue("alert-warning", "Please input the name of the strand.")
            strandNameInputField.focus()
            return false
        }

        strandData.name = name
        let data = await updateStrand(strandData.id, strandData.name)
        if(data.success) {
             // update ui
             updateStrandListUI()
             // notify
             addNotificationToQeue("alert-success", data.message)
        }else {
            // notify
            addNotificationToQeue("alert-danger", data.message)
        }
    }

})
strandListUI.addEventListener("click", async (e) => {

    if(e.target.classList.contains('list-group-item')) {
        let el = strandListUI.querySelector('.list-group-item.active')

        let id = e.target.dataset.selectstrandid
        selectedStrand.id = id
        selectedStrand.name = e.target.innerText
        // update curriculumListUI
        updateCurriculumContents()

        if(el) {
            el.classList.remove('active')
        }
        e.target.classList.add('active')
    }
    // open strand-create-edit-modal
    if(e.target.classList.contains('edit-strand')) {

        strandData.id = e.target.dataset.strandeditid
        strandNameInputField.value = e.target.dataset.strandname
        $("#strand-create-edit-modal").modal('show')

    }
    // delete operation
    if(e.target.classList.contains('delete-strand')) {

        let confirmed = confirm("Are you sure you want to delete this strand?")
        if(confirmed) {
            let id = e.target.dataset.stranddeleteid
            let data = await deleteStrand(id)
            if(data.success) {
                // update ui
                updateStrandListUI()
                // notify
                addNotificationToQeue("alert-success", data.message)
           }else {
               // notify
               addNotificationToQeue("alert-danger", data.message)
           }
        }
    }

})

// SEMESTER OPERATIONS
let semesterListUI = document.querySelector("#semester-list-group")
let createSemesterModalTrigger = document.querySelector("#create-semester-modal-trigger")
let closeSemesterModalTrigger = document.querySelector("#close-semester-modal")
let semesterNameInputField = document.querySelector("#semester-name-input")
let semesterSaveButton = document.querySelector("#semester-save-button")
let semesterListData = []
let semesterData = {
    "id" : "",
    "name" : ""
}

// Update curriculumListUI
async function updateSemesterListUI() {
    // get semesterMasterList
    let result = await getSemesterMasterlist()
    semesterListData = result.data

    // prepare list
    let list = '';
    for(let index in semesterListData) {
        list += `<li class="list-group-item" data-selectsemesterid="${semesterListData[index].id}" data-select-semester-name="${semesterListData[index].name}">
            ${semesterListData[index].name}
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-xs edit-semester" data-semestername='${semesterListData[index].name}' data-semestereditid=${semesterListData[index].id}><i class="fa-solid fa-edit"></i></button>
                <button type="button" class="btn btn-default btn-xs delete-semester" data-semesterdeleteid=${semesterListData[index].id}><i class="fa-solid fa-trash"></i></button>
            </div>
        </li>`
    }
    // update UI
    semesterListUI.innerHTML = list
}
createSemesterModalTrigger.addEventListener("click", () => {

    // clear semesterNameInputField
    semesterNameInputField.value = ""
    // clear semesterData
    semesterData.id = ""
    semesterData.name = ""
    $("#semester-create-edit-modal").modal('show')

})
closeSemesterModalTrigger.addEventListener("click", () => {

    $("#semester-create-edit-modal").modal('hide')

})
semesterSaveButton.addEventListener("click", async (e) => {

    // if semesterData.id is empty its a create function
    if(semesterData.id == "") {
        
        let name = semesterNameInputField.value

        if(name.trim().length <= 0) {

            addNotificationToQeue("alert-warning", "Please input the name of this semester.")
            semesterNameInputField.focus()
            return false
        }

        let data = await createSemester(name.trim())
        if(data.success) {
            // update ui
            updateSemesterListUI()
            // notify
            addNotificationToQeue("alert-success", data.message)
        }else {
            // notify
            addNotificationToQeue("alert-success", data.message)
        }

    }
    // if semesterData.id is not empty its a edit function
    if(semesterData.id !== "") {

        let name = semesterNameInputField.value

        if(name.trim().length <= 0) {

            addNotificationToQeue("alert-warning", "Please input the name of this semester.")
            semesterNameInputField.focus()
            return false
        }

        semesterData.name = name
        let data = await updateSemester(semesterData.id, semesterData.name)
        if(data.success) {
             // update ui
             updateSemesterListUI()
             // notify
             addNotificationToQeue("alert-success", data.message)
        }else {
            // notify
            addNotificationToQeue("alert-danger", data.message)
        }
    }

})
semesterListUI.addEventListener("click", async (e) => {

    if(e.target.classList.contains('list-group-item')) {
        let el = semesterListUI.querySelector('.list-group-item.active')
        let id = e.target.dataset.selectsemesterid
        let name = e.target.innerText
  
        selectedSemester.id = id
        selectedSemester.name = name

        if(el) {
            el.classList.remove('active')
        }
        e.target.classList.add('active')
    }
    // open semester-create-edit-modal
    if(e.target.classList.contains('edit-semester')) {

        semesterData.id = e.target.dataset.semestereditid
        semesterNameInputField.value = e.target.dataset.semestername
        $("#semester-create-edit-modal").modal('show')

    }
    // delete operation
    if(e.target.classList.contains('delete-semester')) {

        let confirmed = confirm("Are you sure you want to delete this semester?")
        if(confirmed) {
            let id = e.target.dataset.semesterdeleteid
            let data = await deleteSemester(id)
            if(data.success) {
                // update ui
                updateSemesterListUI()
                // notify
                addNotificationToQeue("alert-success", data.message)
           }else {
               // notify
               addNotificationToQeue("alert-danger", data.message)
           }
        }
    }

})

// PERIOD OPERATIONS
let periodListUI = document.querySelector("#period-list-group")
let createPeriodModalTrigger = document.querySelector("#create-period-modal-trigger")
let closePeriodModalTrigger = document.querySelector("#close-period-modal")
let periodNameInputField = document.querySelector("#period-name-input")
let periodSaveButton = document.querySelector("#period-save-button")
let periodListData = []
let periodData = {
    "id" : "",
    "name" : ""
}

// Update periodListUI
async function updatePeriodListUI() {
    // get semesterMasterList
    let result = await getPeriodMasterlist()
    periodListData = result.data

    // prepare list
    let list = '';
    for(let index in periodListData) {
        list += `<li class="list-group-item">
            ${periodListData[index].name}
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-xs edit-period" data-periodname='${periodListData[index].name}' data-periodeditid=${periodListData[index].id}><i class="fa-solid fa-edit"></i></button>
                <button type="button" class="btn btn-default btn-xs delete-period" data-perioddeleteid=${periodListData[index].id}><i class="fa-solid fa-trash"></i></button>
            </div>
        </li>`
    }
    // update UI
    periodListUI.innerHTML = list
}
createPeriodModalTrigger.addEventListener("click", () => {

    // clear periodNameInputField
    periodNameInputField.value = ""
    // clear periodData
    periodData.id = ""
    periodData.name = ""
    $("#period-create-edit-modal").modal('show')

})
closePeriodModalTrigger.addEventListener("click", () => {

    $("#period-create-edit-modal").modal('hide')

})
periodSaveButton.addEventListener("click", async (e) => {

    // if periodData.id is empty its a create function
    if(periodData.id == "") {
        
        let name = periodNameInputField.value

        if(name.trim().length <= 0) {

            addNotificationToQeue("alert-warning", "Please input the name of this period.")
            periodNameInputField.focus()
            return false
        }
        
        let data = await createPeriod(name.trim())
        if(data.success) {
            // update ui
            updatePeriodListUI()
            // notify
            addNotificationToQeue("alert-success", data.message)
        }else {
            // notify
            addNotificationToQeue("alert-success", data.message)
        }

    }
    // if periodData.id is not empty its a edit function
    if(periodData.id !== "") {

        let name = periodNameInputField.value

        if(name.trim().length <= 0) {

            addNotificationToQeue("alert-warning", "Please input the name of this period.")
            periodNameInputField.focus()
            return false
        }

        periodData.name = name
        let data = await updatePeriod(periodData.id, periodData.name)
        if(data.success) {
             // update ui
             updatePeriodListUI()
             // notify
             addNotificationToQeue("alert-success", data.message)
        }else {
            // notify
            addNotificationToQeue("alert-danger", data.message)
        }
    }

})
periodListUI.addEventListener("click", async (e) => {

    if(e.target.classList.contains('list-group-item')) {
        let el =periodListUI.querySelector('.list-group-item.active')
        if(el) {
            el.classList.remove('active')
        }
        e.target.classList.add('active')
    }
    // open period-create-edit-modal
    if(e.target.classList.contains('edit-period')) {

        periodData.id = e.target.dataset.periodeditid
        periodNameInputField.value = e.target.dataset.periodname
        $("#period-create-edit-modal").modal('show')

    }
    // delete operation
    if(e.target.classList.contains('delete-period')) {

        let confirmed = confirm("Are you sure you want to delete this period?")
        if(confirmed) {
            let id = e.target.dataset.perioddeleteid
            let data = await deletePeriod(id)
            if(data.success) {
                // update ui
                updatePeriodListUI()
                // notify
                addNotificationToQeue("alert-success", data.message)
           }else {
               // notify
               addNotificationToQeue("alert-danger", data.message)
           }
        }
    }

})


// SUBJECT OPERATIONS
let subjectListUI = document.querySelector("#subject-list-group")
let createSubjectModalTrigger = document.querySelector("#create-subject-modal-trigger")
let closeSubjectModalTrigger = document.querySelector("#close-subject-modal")
let subjectNameInputField = document.querySelector("#subject-name-input")
let subjectSaveButton = document.querySelector("#subject-save-button")
let subjectListData = []
let subjectData = {
    "id" : "",
    "name" : ""
}

// Update subjectListUI
async function updateSubjectListUI() {
    // get subjectMasterList
    let result = await getSubjectMasterList()
    subjectListData = result.data
    
    // prepare list
    let list = '';
    for(let index in subjectListData) {
        list += `<li class="list-group-item" data-subjectid=${subjectListData[index].id} data-subjectsname="${subjectListData[index].name}">
            ${subjectListData[index].name}
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-xs edit-subject" data-subjectname='${subjectListData[index].name}' data-subjecteditid=${subjectListData[index].id}><i class="fa-solid fa-edit"></i></button>
                <button type="button" class="btn btn-default btn-xs delete-subject" data-subjectdeleteid=${subjectListData[index].id}><i class="fa-solid fa-trash"></i></button>
            </div>
        </li>`
    }
    // update UI
    subjectListUI.innerHTML = list
}
createSubjectModalTrigger.addEventListener("click", () => {
    
    // clear subjectNameInputField
    subjectNameInputField.value = ""
    // clear subjectData
    subjectData.id = ""
    subjectData.name = ""
    $("#subject-create-edit-modal").modal('show')

})
closeSubjectModalTrigger.addEventListener("click", () => {

    $("#subject-create-edit-modal").modal('hide')

})
subjectSaveButton.addEventListener("click", async (e) => {

    // if subjectData.id is empty its a create function
    if(subjectData.id == "") {
        
        let name = subjectNameInputField.value

        if(name.trim().length <= 0) {

            addNotificationToQeue("alert-warning", "Please input the name of this subject.")
            subjectNameInputField.focus()
            return false

        }

        let data = await createSubject(name.trim())
        if(data.success) {
            // update ui
            updateSubjectListUI()
            // emtpy the field and focus
            subjectNameInputField.value = ""
            subjectNameInputField.focus()
            // notify
            addNotificationToQeue("alert-success", data.message)
        }else {
            // notify
            addNotificationToQeue("alert-success", data.message)
        }

    }
    // if subjectData.id is not empty its an edit function
    if(subjectData.id !== "") {

        let name = subjectNameInputField.value

        if(name.trim().length <= 0) {

            addNotificationToQeue("alert-warning", "Please input the name of this subject.")
            subjectNameInputField.focus()
            return false

        }

        subjectData.name = name
        
        let data = await updateSubject(subjectData.id, subjectData.name)
        if(data.success) {
             // update ui
             updateSubjectListUI()
             // notify
             addNotificationToQeue("alert-success", data.message)
        }else {
            // notify
            addNotificationToQeue("alert-danger", data.message)
        }
    }

})
subjectListUI.addEventListener("click", async (e) => {
    
    if(e.target.classList.contains('list-group-item')) {
        let el = subjectListUI.querySelector('.list-group-item.active')
        if(el) {
            el.classList.remove('active')
        }
        e.target.classList.add('active')

        let alreadyIncluded = false

        for(let i in curriculum_subjects) {
            if(curriculum_subjects[i].curriculum_id == selectedCurriculum.id && curriculum_subjects[i].strand_id == selectedStrand.id && curriculum_subjects[i].semester_id == selectedSemester.id && curriculum_subjects[i].subject_id == e.target.dataset.subjectid) {
                alreadyIncluded = true
                break;
            }
        }

        if(!alreadyIncluded) {
            // add to curriculum_subjects to be update the ui
            curriculum_subjects.push({
                "curriculum_id":selectedCurriculum.id,
                "strand_id":selectedStrand.id,
                "semester_id":selectedSemester.id,
                "subject_id": e.target.dataset.subjectid
            })

            // add subjects to be save
            subjects_to_add.push({
                "curriculum_id":selectedCurriculum.id,
                "strand_id":selectedStrand.id,
                "semester_id":selectedSemester.id,
                "subject_id": e.target.dataset.subjectid
            })
        }        
        
        updateCurriculumContents()
    }
    // open subject-create-edit-modal
    if(e.target.classList.contains('edit-subject')) {
       
        subjectData.id = e.target.dataset.subjecteditid
        subjectData.name = e.target.dataset.subjectname
        subjectNameInputField.value = e.target.dataset.subjectname
        $("#subject-create-edit-modal").modal('show')

    }
    // delete operation
    if(e.target.classList.contains('delete-subject')) {

        let confirmed = confirm("Are you sure you want to delete this subject?")
        if(confirmed) {
            let id = e.target.dataset.subjectdeleteid
            let data = await deleteSubject(id)
            if(data.success) {
                // update ui
                updateSubjectListUI()
                // notify
                addNotificationToQeue("alert-success", data.message)
           }else {
               // notify
               addNotificationToQeue("alert-danger", data.message)
           }
        }
    }

})

// CURRICULUM SUBJECTS
let curriculumLabelUI = document.querySelector("#curriculum-label")
let curriculumContentsUI = document.querySelector("#curriculum-subjects")
let saveSubjectsOfCurriculum = document.querySelector("#save-subjects-to-curriculum")
let getCurriculumSubjectsButton = document.querySelector("#list-subjects-from-curriculum")

let selectedSemester = {
    "id": "",
    "name": ""
}
let selectedCurriculum = {
    "id": "",
    "name": ""
}
let selectedStrand = {
    "id": "",
    "name": ""
}
let curriculum_subjects = []
let subjects_to_add = []

async function updateCurriculumContents() 
{   
    let strandName = selectedStrand.name == "None" ? "" : selectedStrand.name
    let name = `${selectedCurriculum.name} ${strandName} Curriculum`
    curriculumLabelUI.innerText = name

    let contents = ``
    for(let i in curriculum_subjects) {
        contents += `<li class="list-group-item">
                        <div>
                            <h4 class="list-group-item-heading">${subjectListData[curriculum_subjects[i].subject_id].name}</h4>
                            <small class="list-group-item-text text-muted">${semesterListData[curriculum_subjects[i].semester_id].name}</small>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-xs remove-subject-from-curriculum" 
                                data-curriculumid=${curriculum_subjects[i].curriculum_id}
                                data-strandid=${curriculum_subjects[i].strand_id}
                                data-semesterid=${curriculum_subjects[i].semester_id}
                                data-subjectid=${curriculum_subjects[i].subject_id}
                            ><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </li>`
    }

    curriculumContentsUI.innerHTML = contents
    

}
curriculumContentsUI.addEventListener("click", async (e) => {
    
    if(e.target.classList.contains('remove-subject-from-curriculum')) {
        let curriculumid = e.target.dataset.curriculumid
        let strandid = e.target.dataset.strandid
        let semesterid = e.target.dataset.semesterid
        let subjectid = e.target.dataset.subjectid
        
        let confirmed = confirm("Are you sure you want to remove this subject from this curriculum?")

        if(!confirmed) {
            return false
        }

        let data = await removeSubjectFromCurriculum(curriculumid, strandid, semesterid, subjectid)
        console.log(data)
        if(data.success) {

            // remove from curriculum_subjects 
            for(let i in curriculum_subjects) {
                if(curriculum_subjects[i].curriculum_id == curriculumid && curriculum_subjects[i].strand_id == strandid && curriculum_subjects[i].semester_id == semesterid && curriculum_subjects[i].subject_id == subjectid) {
                    curriculum_subjects.splice(i,1)
                    break;
                }
            }
            // after remove update ui
            updateCurriculumContents()
            // notify
            addNotificationToQeue("alert-success", data.message)

        }
    }

})

saveSubjectsOfCurriculum.addEventListener("click", async (e)=> {

    if(subjects_to_add.length <= 0 || selectedCurriculum.id == "" || selectedStrand.id == "") {
        addNotificationToQeue("alert-warning", "Please select a curriculum, strand and a number of subjects.")
        return false
    }
    
    let data = await addSubjectToCurriculum(subjects_to_add, selectedCurriculum.id, selectedStrand.id)
    
    if(data.success) {
        // after saving empty the subjects_to_add array
        // set subjects_to_add to empty
        subjects_to_add.length = 0
        // update ui
        updateCurriculumContents()
        // notify
        addNotificationToQeue("alert-success", data.message)

    }else{

        // notify
        addNotificationToQeue("alert-danger", data.message)

    }

})

getCurriculumSubjectsButton.addEventListener("click", async (e)=>{
    
    if(selectedCurriculum.id != "" && selectedStrand.id != "") {

        let result = await getCurriculumSubjects(selectedCurriculum.id, selectedStrand.id)
        curriculum_subjects = result.data
        updateCurriculumContents()

    }else{
        addNotificationToQeue("alert-danger", "Please select a curriculum and strand.")
    }

})

// TRAITS OPERATION
let traitListUI = document.querySelector("#trait-list-group")
let createTraitModalTrigger = document.querySelector("#create-trait-modal-trigger")
let closeTraitModalTrigger = document.querySelector("#close-trait-modal")
let traitNameInputField = document.querySelector("#trait-name-input")
let traitSaveButton = document.querySelector("#trait-save-button")
let curriculumTraitsListUI = document.querySelector("#curriculum-traits")
let traitListData = []
let traitData = {
    "id" : "",
    "description" : ""
}

let curriculum_traits = []

let subjectsPanelBtn = document.querySelector("#show-subjects-panel")
let curriculumSubjectPanel = document.querySelector("#curriculum-subject-panel")
let subjectMasterListPanel = document.querySelector("#subject-master-list-panel")

let traitsPanelBtn = document.querySelector("#show-traits-panel")
let curriculumTraitPanel = document.querySelector("#curriculum-trait-panel")
let traitMasterListPanel = document.querySelector("#trait-master-list-panel")

let saveTraitsToCurriculum = document.querySelector("#save-traits-to-curriculum")
let listTraitsFromCurriculum = document.querySelector("#list-traits-from-curriculum")

// open trait modal
createTraitModalTrigger.addEventListener("click", (e)=>{
    // always empty when opening the modal
    traitData.description = ""
    traitData.id = ""

    $('#trait-create-edit-modal').modal('show')
})
// close trait modal
closeTraitModalTrigger.addEventListener("click", (e)=>{
    $('#trait-create-edit-modal').modal('hide')
})
// save trait
traitSaveButton.addEventListener("click", async (e)=>{
    
    // create trait
    if(traitData.id.length <= 0) {

        // means create trait
        let desc = traitNameInputField.value
        if(desc.trim().length <= 0) {
            addNotificationToQeue('alert-warning','Please fill out the description of this trait.')
            traitNameInputField.focus()
            return false
        }

        let result = await saveTrait(desc)
        if(result.success) {
            addNotificationToQeue("alert-success", result.message)
            // empty and focus on the field
            traitNameInputField.value = ""
            traitNameInputField.focus()
            // update traitListUI
            updateTraitListUI()
        } else {
            addNotificationToQeue("alert-danger", result.message)
            traitNameInputField.focus()
        }

    }  else {

        // means update trait
        let desc = traitNameInputField.value
        if(desc.trim().length <= 0) {
            addNotificationToQeue('alert-warning','Please fill out the description of this trait.')
            traitNameInputField.focus()
            return false
        }
        
        let id = traitData.id
        let result = await updateTrait(id, desc)
        if(result.success) {
            addNotificationToQeue("alert-success", result.message)
            traitNameInputField.focus()
            // update traitListUI
            updateTraitListUI()
        } else {
            addNotificationToQeue("alert-danger", result.message)
            traitNameInputField.focus()
        }
    }

})
// Edit and Delete Trait Triggers
traitListUI.addEventListener("click", async (e) => {

    if(e.target.classList.contains('delete-trait')) {

        let confirmed = confirm("Are you sure you want to delete this trait?")
        if(!confirmed) {
            return false
        }

        let id = e.target.dataset.traitdeleteid
        let result = await deleteTrait(id)
        if(result.success) {
            addNotificationToQeue("alert-success", result.message)
            updateTraitListUI()
        }else{
            addNotificationToQeue("alert-warning", result.message)
        }
    }

    if(e.target.classList.contains('edit-trait')) {

        traitData.description = e.target.dataset.traitdescription
        traitData.id = e.target.dataset.traiteditid

        traitNameInputField.value = e.target.dataset.traitdescription

        $('#trait-create-edit-modal').modal('show')

    }

    if(e.target.classList.contains('list-group-item')) {

        if(selectedCurriculum.id.length <= 0 || selectedStrand.id.length <= 0 || selectedSemester.id.length <= 0) {
            addNotificationToQeue("alert-warning", "Please select a curriculum, strand, and a semester.")
            return false
        }

        let activeEl = traitListUI.querySelector(".list-group-item.active")
        if(activeEl != null) {
            activeEl.classList.remove('active')
        }
        e.target.classList.add('active')

        // check if trait is already included
        let alreadyIncluded = false
        for(let i in curriculum_traits) {

            if(curriculum_traits[i].curriculum_id == selectedCurriculum.id && curriculum_traits[i].strand_id == selectedStrand.id && curriculum_traits[i].semester_id == selectedSemester.id && curriculum_traits[i].trait_id == e.target.dataset.traitid) {
                alreadyIncluded = true
                break
            }

        }

        if(alreadyIncluded == false) {
            curriculum_traits.push({
                "curriculum_id": selectedCurriculum.id,
                "strand_id": selectedStrand.id,
                "semester_id": selectedSemester.id,
                "trait_id": e.target.dataset.traitid
            })
        }

        updateCurriculumTraitsListUI()
    }

})

// save traits to curriculum
saveTraitsToCurriculum.addEventListener('click', async (e) => {

    let result = await addTraitToCurriculum(curriculum_traits, selectedCurriculum.id, selectedStrand.id)
    
    if(result.success) {
        addNotificationToQeue("alert-success", result.message)
    }else {
        addNotificationToQeue("alert-success", result.message)
    }


})

// get traits from curriculum
listTraitsFromCurriculum.addEventListener('click', async (e)=>{

    if(selectedCurriculum.id.length <= 0 || selectedStrand.id.length <= 0) {
        addNotificationToQeue("alert-danger", "Please select a curriculum and a strand.")
        return false
    }

    let curriculum_id = selectedCurriculum.id
    let strand_id = selectedStrand.id
    
    let result = await getCurriculumTraits(curriculum_id, strand_id)

    if(result.success) {
        curriculum_traits = result.data
        updateCurriculumTraitsListUI()
        addNotificationToQeue("alert-success", result.message)
    } else {
        addNotificationToQeue("alert-warning", "This curriculum has no traits assign yet.")
    }
})

curriculumTraitsListUI.addEventListener("click", async (e) => {

    if(e.target.classList.contains('remove-trait-from-curriculum')) {
        
        let confirmed = confirm("Are you sure you want to remove this trait from this curriculum?")

        if(!confirmed) {
            return false
        }

        let result = await removeTraitFromCurriculum(e.target.dataset.id)

        if(result.success) {

            addNotificationToQeue("alert-success", result.message)

            for(let i in curriculum_traits) {
                if(curriculum_traits[i].curriculum_id == e.target.dataset.curriculumid && curriculum_traits[i].strand_id == e.target.dataset.strandid && curriculum_traits[i].semester_id == e.target.dataset.semesterid && curriculum_traits[i].trait_id == e.target.dataset.traitid) {

                    // remove from curriculum_traits
                    curriculum_traits.splice(i,1)
                    break

                }
            }

            updateCurriculumTraitsListUI()

        } else {

            addNotificationToQeue("alert-warning", result.message)

        }
    }

})

function updateCurriculumTraitsListUI()
{
    let list = ``
    for(let i in curriculum_traits) {
        list += `<li class="list-group-item">
            <div>
                <h4 class="list-group-item-heading">${traitListData[curriculum_traits[i].trait_id].description}</h4>
                <small class="list-group-item-text text-muted">${semesterListData[curriculum_traits[i].semester_id].name}</small>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-xs remove-trait-from-curriculum" 
                    data-id=${curriculum_traits[i].id}
                    data-curriculumid=${curriculum_traits[i].curriculum_id}
                    data-strandid=${curriculum_traits[i].strand_id}
                    data-semesterid=${curriculum_traits[i].semester_id}
                    data-traitid=${curriculum_traits[i].trait_id}
                ><i class="fa-solid fa-trash"></i></button>
            </div>
        </li>`
    }

    curriculumTraitsListUI.innerHTML = list
}



async function updateTraitListUI() {
    // get traitMasterList
    let result = await getTraitMasterList()
    traitListData = result.data
    
    // prepare list
    let list = '';
    for(let index in traitListData) {
        list += `<li class="list-group-item" data-traitid=${traitListData[index].id} data-subjectsname="${traitListData[index].description}">
            ${traitListData[index].description}
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-xs edit-trait" data-traitdescription='${traitListData[index].description}' data-traiteditid=${traitListData[index].id}><i class="fa-solid fa-edit"></i></button>
                <button type="button" class="btn btn-default btn-xs delete-trait" data-traitdeleteid=${traitListData[index].id}><i class="fa-solid fa-trash"></i></button>
            </div>
        </li>`
    }
    // update UI
    traitListUI.innerHTML = list
}

// Switch From Subjects to Traits UI
subjectsPanelBtn.addEventListener("click", (e)=>{
    e.target.classList.add('active')
    traitsPanelBtn.classList.remove('active')

    curriculumSubjectPanel.setAttribute('style', 'display:block;')
    curriculumTraitPanel.setAttribute('style', 'display:none;')

    subjectMasterListPanel.setAttribute("style", "display:block;")
    traitMasterListPanel.setAttribute("style", "display:none;")
})

traitsPanelBtn.addEventListener("click", (e)=>{
    e.target.classList.add('active')
    subjectsPanelBtn.classList.remove('active')

    curriculumTraitPanel.setAttribute('style', 'display:block;')
    curriculumSubjectPanel.setAttribute('style', 'display:none;')

    traitMasterListPanel.setAttribute("style", "display:block;")
    subjectMasterListPanel.setAttribute("style", "display:none;")
})

// Execute after windows is fully loaded
window.addEventListener("load", (e)=> {

    // set modal Configuration for curriculum-create-edit-modal
    $('#curriculum-create-edit-modal').modal(modalConfig)
    $('#strand-create-edit-modal').modal(modalConfig)
    $('#semester-create-edit-modal').modal(modalConfig)
    $('#period-create-edit-modal').modal(modalConfig)
    $('#subject-create-edit-modal').modal(modalConfig)
    $('#trait-create-edit-modal').modal(modalConfig)
    // get Curriculum Master List
    updateCurriculumListUI()
    // get Strand Master List
    updateStrandListUI()
    // get Semester Master List
    updateSemesterListUI()
    // get Period Master List
    updatePeriodListUI()
    // get Subject Master List
    updateSubjectListUI()
    // get Trait Master List
    updateTraitListUI()
})

