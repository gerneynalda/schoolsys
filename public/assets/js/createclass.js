let studentListUI = document.querySelector("#student-list-group")
let levelListUI = document.querySelector("#level-list-group")
let sectionListUI = document.querySelector("#section-list-group")
let teacherListUI = document.querySelector("#teacher-list-group")
let schoolyearListUI = document.querySelector("#schoolyear-list-group")
let classListUI = document.querySelector('#class-list-group')
let classNameFieldUI = document.querySelector("#class-name-add-class-form")
let classStudentOfSchoolyearUI = document.querySelector("#class-students-of-schoolyear")
let classAdviserOfSchoolyearUI = document.querySelector("#class-students-of-schoolyear-adviser")
let classStudentUI = document.querySelector("#class-student-list")

let classLevelInputField = document.querySelector("#level-field-add-class-form")
let classSectionInputField = document.querySelector("#section-field-add-class-form")
let classAdviserInputField = document.querySelector("#adviser-field-add-class-form")
let classSaveButton = document.querySelector("#save-class-form")
let saveClassStudentList = document.querySelector("#save-class-students-list")
let listClassStudents = document.querySelector("#list-students-from-class")
let classEditeAdviserModel = document.querySelector("#class-edit-adviser-modal")
let closeClassEditAdviserModal = document.querySelector("#close-class-edit-adviser-modal")
let classAdviserListUI = document.querySelector("#class-adviser-input")

let classIDInput = document.querySelector("#class-id-input")
let saveClassAdivserBtn = document.querySelector("#class-adviser-change-save-button")

let createLevelModalTrigger = document.querySelector("#create-level-modal-trigger")
let closeLevelModalTrigger = document.querySelector("#close-level-edit-modal")
let levelCreateEditField = document.querySelector("#level-name-input")
let levelSaveButton = document.querySelector("#level-save-button")

let createSectionModalTrigger = document.querySelector('#create-section-modal-trigger')
let closeSectionModalTrigger = document.querySelector("#close-section-modal")
let sectionCreateEditField = document.querySelector("#section-name-input")
let sectionSaveButton = document.querySelector("#section-save-button")

let createTeacherModalTrigger = document.querySelector('#create-teacher-modal-trigger')
let closeTeacherModalTrigger = document.querySelector("#close-teacher-modal")
let teacherCreateEditLastnameField = document.querySelector("#teacher-lastname-input")
let teacherCreateEditFirstnameField = document.querySelector("#teacher-firstname-input")
let teacherCreateEditMiddlenameField = document.querySelector("#teacher-middlename-input")
let teacherCreateEditSuffixField = document.querySelector("#teacher-suffix-input")
let teacherSaveButton = document.querySelector("#teacher-save-button")

let createSchoolyearModalTrigger = document.querySelector("#create-schoolyear-modal-trigger")
let closeSchoolyearModalTrigger = document.querySelector("#close-schoolyear-modal")
let schoolyearCreateEditField = document.querySelector("#schoolyear-name-input")
let schoolyearSaveButton = document.querySelector("#schoolyear-save-button")

let studentSearchUI = document.querySelector("#search-student")

let studentListUiIndex
let className = {
    "level" : "",
    "section" : ""
}
let classStudents = {
    "class" : "",
    "schoolyear" : "",
    "adviser": ""
}
let studentsInClass = {
    "class_id" : "",
    "schoolyear_id": "",
    "lrn"   : []
}
let levelCreateEditData = {
    "id" : "",
    "name" : ""
}
let sectionCreateEditData = {
    "id": "",
    "name": ""
}
let schoolyearCreateEditData = {
    "id" : "",
    "name" : ""
}
let teacherCreateEditData = {
    "id":"",
    "lastname":"",
    "firstname":"",
    "middlename":"",
    "suffix":""
}
let modalConfig = {
    keyboard: false,
    backdrop: 'static',
}


// load data when the page is completely loaded.
window.addEventListener("load", async (e)=> {

    let student_list = await getStudentMasterlist()
    updateStudentListUI(student_list, studentListUI)
    addNotificationToQeue("alert-info", student_list.message)

    let level_list = await getLevelMasterList()
    updateLevelListUI(level_list, levelListUI)
    addNotificationToQeue("alert-info", level_list.message)

    let section_list = await getSectionMasterList()
    updateSectionListUI(section_list, sectionListUI)
    addNotificationToQeue("alert-info", section_list.message)

    let teacher_list = await getTeachersMasterList()
    updateTeacherListUI(teacher_list, teacherListUI)
    addNotificationToQeue("alert-info", teacher_list.message)

    let schoolyear_list = await getSchoolyearMasterList()
    updateSchoolyearListUI(schoolyear_list, schoolyearListUI)
    addNotificationToQeue("alert-info", schoolyear_list.message)

    let classess_list = await getClassMasterList()
    updateClassMasterListUI(classess_list, classListUI)
    addNotificationToQeue("alert-info", classess_list.message)

    // set modal configurations
    $("#level-create-edit-modal").modal(modalConfig)
    $("#section-create-edit-modal").modal(modalConfig)
    $("#schoolyear-create-edit-modal").modal(modalConfig)
    $("#teacher-create-edit-modal").modal(modalConfig)
    $("#class-edit-adviser-modal").modal(modalConfig)

})

let timeout
studentSearchUI.addEventListener("keyup", (e) => {
    // add clear time out so that the searchStudent function will only trigger after the user finished typing
    clearTimeout(timeout)
    timeout = setTimeout(()=>{
        searchStudent(e.target.value)
    }, 200)

})

studentListUI.addEventListener("click", (e) => {

    if(e.target.classList.contains("list-group-item")) {

        // add lrn only if its not in studentsInClass array
        if(!studentsInClass.lrn.includes(e.target.dataset.lrn)){
            studentsInClass.lrn.push(e.target.dataset.lrn)
            // update studentClassUI
            updateClassStudentUI(studentsInClass.lrn, classStudentUI)    
        }else{
            addNotificationToQeue("alert-danger", "This student is already in this class.")
        }
    }

})

levelListUI.addEventListener("click", async(e) => {

    if(e.target.classList.contains("list-group-item")) {

        let activeEl = levelListUI.querySelector(".list-group-item.active")
        if(activeEl != null) {  
            activeEl.classList.remove('active')
        }
        e.target.classList.add('active')

        let id = e.target.dataset.id
        let text = e.target.innerText
        // update classLevelInputField
        classLevelInputField.value = id
        // update classNameFieldUI
        let str = text
        // remove beginning % end spaces
        className.level = str.trim()
        updateClassNameField()
    }
    // delete level
    if(e.target.classList.contains('delete-level')) {
        
        let confirmed = confirm("Are you sure you want to delete this level?")
        if(confirmed) {

            let levelid = e.target.dataset.deletelevelid
            let data = await deleteLevel(levelid)

            if(data.success) {
                let level_list = await getLevelMasterList()
                updateLevelListUI(level_list, levelListUI)
                addNotificationToQeue("alert-success", data.message)
            }else{
                addNotificationToQeue("alert-danger", data.message)
            }
        }

    }
    // edit level
    if(e.target.classList.contains('edit-level')) {
    
        let levelid = e.target.dataset.editlevelid
        // get name of level from the .list-group-item element
        let name = levelListUI.querySelector(`[data-id="${levelid}"]`).innerText
        // update the id and name
        levelCreateEditData.id = levelid
        levelCreateEditData.name = name
        // update the Modal with the level information
        updateLevelCreateEditModalUI()
        // show the modal
        $("#level-create-edit-modal").modal('show')
    }
})

sectionListUI.addEventListener("click", async (e) => {
    if(e.target.classList.contains("list-group-item")) {

        let activeEl = sectionListUI.querySelector(".list-group-item.active")
        if(activeEl != null) {
            activeEl.classList.remove('active')
        }
        e.target.classList.add('active')

        let id = e.target.dataset.id    
        let text = e.target.innerText
        // update classSectionInputField
        classSectionInputField.value = id
        // update classNameFieldUI
        let str = text
        // remove beginning % end spaces
        className.section = str.trim()
        updateClassNameField()
    }
     // delete section
     if(e.target.classList.contains('delete-section')) {
        
        let confirmed = confirm("Are you sure you want to delete this section?")
        if(confirmed) {

            let sectionid = e.target.dataset.deletesectionid
            let data = await deleteSection(sectionid)

            if(data.success) {
                let section_list = await getSectionMasterList()
                updateSectionListUI(section_list, sectionListUI)
                addNotificationToQeue("alert-success", data.message)
            }else{
                addNotificationToQeue("alert-danger", data.message)
            }
        }
    }
    // edit section
    if(e.target.classList.contains('edit-section')) {
    
        let sectionid = e.target.dataset.editsectionid
        // get name of section from the .list-group-item element
        let name = sectionListUI.querySelector(`[data-id="${sectionid}"]`).innerText
        // update the id and name
        sectionCreateEditData.id = sectionid
        sectionCreateEditData.name = name
        // update the Modal with the level information
        updateSectionCreateEditModalUI()
        // show the modal
        $("#section-create-edit-modal").modal('show')
    }
})

classListUI.addEventListener("click", async(e)=>{

    if(e.target.classList.contains("list-group-item")) {

        let activeEl = classListUI.querySelector(".list-group-item.active")
        if(activeEl != null) {
            activeEl.classList.remove('active')
        }
        e.target.classList.add('active')

        let id = e.target.dataset.id

        classStudents.class = e.target.dataset.classname
        classStudents.adviser = e.target.dataset.adviser

        studentsInClass.class_id = id
        updateClassStudentOfSchoolyearUI()

        // List the students of this class in this schoolyear
        // if studentsInClass.class_id or studentsInClass.schoolyear_id is empty dont proceed to the rest of the code and notify the user
        if(studentsInClass.class_id == "" || studentsInClass.schoolyear_id == "") {
            addNotificationToQeue("alert-danger", "Please select a class and a school year.")
            return false
        }

        let result = await getSchoolyearClassStudentList(studentsInClass.class_id, studentsInClass.schoolyear_id)
        // reset lrn array to empty
        studentsInClass.lrn = []
        // rest classStudentUI.innerHTML
        classStudentUI.innerHTML = ""
        // insert new lrn to studentsInClass
        if(result.data.length > 0) {
            for(let i in result.data) {
                studentsInClass.lrn.push(result.data[i].lrn)
            }
            // update ui
            updateClassStudentUI(studentsInClass.lrn, classStudentUI)  
        }

    }
    // delete class
    if(e.target.classList.contains("delete-class")) {

        let confirmed = confirm("Are you sure you want to delete this class?")
        if(confirmed) {
            let id = e.target.dataset.classid
            let result = await deleteClass(id)
            if(result.success) {
                // get ClassMasterList
                let class_list = await getClassMasterList()
                updateClassMasterListUI(class_list, classListUI)
                addNotificationToQeue("alert-success", result.message)
            }
        }

    }
    
    // change adviser
    if(e.target.classList.contains('edit-class')) {
        let advisers = await getTeachersMasterList()
        let list = ''
        let selectedEmpuid = e.target.dataset.empuid
        for(let i in advisers.data) {
            list += `<option value="${advisers.data[i].empuid}" ${selectedEmpuid == advisers.data[i].empuid? "selected" : ""}>${advisers.data[i].lastname}, ${advisers.data[i].firstname} ${advisers.data[i].middlename} ${advisers.data[i].suffix}</option>`
        }
        classAdviserListUI.innerHTML = list

        classIDInput.value = e.target.dataset.classid

        $("#class-edit-adviser-modal").modal("show")
    }
})
saveClassAdivserBtn.addEventListener("click", async (e)=> {
    let empuid = classAdviserListUI.value
    let classid = classIDInput.value

    let result  = await updateClassAdviser(classid, empuid)

    if(result.success) {
        let class_list = await getClassMasterList()
        updateClassMasterListUI(class_list, classListUI)
        addNotificationToQeue("alert-success", result.message)
    }else {
        addNotificationToQeue("alert-danger", result.message)
    }
})

// save class function
classSaveButton.addEventListener("click", async (e) => {
    let level = classLevelInputField.value
    let section = classSectionInputField.value
    let adviser = classAdviserInputField.value
    

    if(level.length <= 0 || section.length <= 0 || adviser.length <= 0) {
        addNotificationToQeue("alert-warning", "Please select a level, section, and an adviser.")
        return false
    }

    // saving class
    let newClass = await createNewClass(level, section, adviser)

    if(newClass.success) {
        addNotificationToQeue("alert-success", newClass.message)
        // update the list
        let classess_list = await getClassMasterList()
        updateClassMasterListUI(classess_list, classListUI)
    }else {
        addNotificationToQeue("alert-danger", newClass.message)
    }
    
})
// close class edit adviser modal
closeClassEditAdviserModal.addEventListener("click", (e)=>{
    
    $("#class-edit-adviser-modal").modal("hide")
})

schoolyearListUI.addEventListener("click", async(e)=>{

    if(e.target.classList.contains("list-group-item")) {

        let activeEl = schoolyearListUI.querySelector(".list-group-item.active")
        if(activeEl != null) {
            activeEl.classList.remove('active')
        }
        e.target.classList.add('active')

        let id = e.target.dataset.id
        let text = e.target.innerText

        classStudents.schoolyear = text
        studentsInClass.schoolyear_id = id
        updateClassStudentOfSchoolyearUI()
    }
    // delete schoolyear
    if(e.target.classList.contains('delete-schoolyear')) {
        
        let confirmed = confirm("Are you sure you want to delete this schoolyear?")
        if(confirmed) {

            let schoolyearid = e.target.dataset.deleteschoolyearid
            let data = await deleteSchoolyear(schoolyearid)

            if(data.success) {
                let schoolyear_list = await getSchoolyearMasterList()
                updateSectionListUI(schoolyear_list, schoolyearListUI)
                addNotificationToQeue("alert-success", data.message)
            }else{
                addNotificationToQeue("alert-danger", data.message)
            }
        }
    }
    // edit schoolyear
    if(e.target.classList.contains('edit-schoolyear')) {
    
        let schoolyearid = e.target.dataset.editschoolyearid
        // get name of schoolyearid from the .list-group-item element
        let name = schoolyearListUI.querySelector(`[data-id="${schoolyearid}"]`).innerText
        // update the id and name
        schoolyearCreateEditData.id = schoolyearid
        schoolyearCreateEditData.name = name
        // update the Modal with the level information
        updateSchoolyearCreateEditModalUI()
        // show the modal
        $("#schoolyear-create-edit-modal").modal('show')
    }
})

classStudentUI.addEventListener("click", async (e)=>{
    
    let lrn = ''
    let index = ''
    // remove student from a class
    if(e.target.classList.contains("remove-student-from-class")) {

        let confirmed = confirm("Are you sure you want to remove this student from the class?")

        if(confirmed) {
            lrn = e.target.dataset.removelrn
            let data = await removeStudentFromClass(lrn, studentsInClass.class_id, studentsInClass.schoolyear_id)
            
            if(data.success) {
                index = studentsInClass.lrn.indexOf(lrn)
                studentsInClass.lrn.splice(index,1)
                // update ui
                updateClassStudentUI(studentsInClass.lrn, classStudentUI)
                addNotificationToQeue("alert-success", "Student remove from class.")
            }
        }
    }

})

saveClassStudentList.addEventListener("click", async(e)=> {
    
    // save students to class for this school year
    if(e.target.classList.contains("save-students-to-class")) {

        if(studentsInClass.class_id == "" || studentsInClass.schoolyear_id == "" || studentsInClass.lrn.length <= 0) {
            addNotificationToQeue("alert-danger", "Please select a class, a school year and students.")
            return false
        }

        let data = await addStudentsToClass(studentsInClass.lrn, studentsInClass.class_id, studentsInClass.schoolyear_id)
        if(data.message !== "") {
            addNotificationToQeue("alert-success", data.message)
        }
    }
    // list students from this class for this school year
    if(e.target.classList.contains("list-students-from-class")) {

        // if studentsInClass.class_id or studentsInClass.schoolyear_id is empty dont proceed to the rest of the code and notify the user
        if(studentsInClass.class_id == "" || studentsInClass.schoolyear_id == "") {
            addNotificationToQeue("alert-danger", "Please select a class and a school year.")
            return false
        }

        let result = await getSchoolyearClassStudentList(studentsInClass.class_id, studentsInClass.schoolyear_id)
        // reset lrn array to empty
        studentsInClass.lrn = []
        // rest classStudentUI.innerHTML
        classStudentUI.innerHTML = ""
        // insert new lrn to studentsInClass
        if(result.data.length > 0) {
            for(let i in result.data) {
                studentsInClass.lrn.push(result.data[i].lrn)
            }
            // update ui
            updateClassStudentUI(studentsInClass.lrn, classStudentUI)  
        }

    }

})

createLevelModalTrigger.addEventListener("click", (e)=>{
    // clear levelCreateEditField value
    levelCreateEditField.value = ""
    // focus on levelCreateEditField
    levelCreateEditField.focus()
    // clear levelCreateEditData object
    levelCreateEditData.id = ""
    levelCreateEditData.name = ""
    $("#level-create-edit-modal").modal('show')
})

closeLevelModalTrigger.addEventListener("click", (e)=>{
    $("#level-create-edit-modal").modal('hide')
})

levelSaveButton.addEventListener("click", async () => {

    // if lvelCreateEditData.id is empty means its a Create level operation
    if(levelCreateEditData.id == "") {

        let name = levelCreateEditField.value

        if(name.trim().length <= 0) {
            addNotificationToQeue("alert-warning", "Please fill out the name field.")
            levelCreateEditField.focus()
            return false
        }

        let data = await createLevel(name)
        if(data.success) {
            // get new list of level
            let level_list = await getLevelMasterList()
            updateLevelListUI(level_list, levelListUI)
            // clear levelCreateEditData object
            levelCreateEditData.id = ""
            levelCreateEditData.name = ""
            // notification 
            addNotificationToQeue("alert-success", data.message)
        }else {
            addNotificationToQeue("alert-danger", data.message)
        }

    }else {

        let name = levelCreateEditField.value

        if(name.trim().length <= 0) {
            addNotificationToQeue("alert-warning", "Please fill out the name field.")
            levelCreateEditField.focus()
            return false
        }

        levelCreateEditData.name = name
        // edit operation
        let data = await updateLevel(levelCreateEditData.id, levelCreateEditField.value)
        if(data.success) {

            let level_list = await getLevelMasterList()
            updateLevelListUI(level_list, levelListUI)
            addNotificationToQeue("alert-success", data.message)

        }else {
            addNotificationToQeue("alert-danger", data.message)
        }
    }
    
})

createSectionModalTrigger.addEventListener("click", (e)=>{
    // clear sectionCreateEditField value
    sectionCreateEditField.value = ""
    // focus on sectionCreateEditField
    sectionCreateEditField.focus()
    // clear sectionCreateEditData object
    sectionCreateEditData.id = ""
    sectionCreateEditData.name = ""
    $("#section-create-edit-modal").modal('show')
})

closeSectionModalTrigger.addEventListener("click", (e)=>{
    $("#section-create-edit-modal").modal('hide')
})

sectionSaveButton.addEventListener("click", async () => {

    // if sectionCreateEditData.id is empty means its a Create section operation
    if(sectionCreateEditData.id == "") {

        let name = sectionCreateEditField.value

        if(name.trim().length <= 0) {
            addNotificationToQeue("alert-warning", "Please fill out the name field.")
            sectionCreateEditField.focus()
            return false
        }

        let data = await createSection(name)
        if(data.success) {
            // get new list of section
            let section_list = await getSectionMasterList()
            updateSectionListUI(section_list, sectionListUI)
            // clear sectionCreateEditData object
            sectionCreateEditData.id = ""
            sectionCreateEditData.name = ""
            // notification 
            addNotificationToQeue("alert-success", data.message)
        }else {
            addNotificationToQeue("alert-danger", data.message)
        }

    }else {
        let name = sectionCreateEditField.value

        if(name.trim().length <= 0) {
            addNotificationToQeue("alert-warning", "Please fill out the name field.")
            sectionCreateEditField.focus()
            return false
        }

        sectionCreateEditData.name = name
        // edit operation
        let data = await updateSection(sectionCreateEditData.id, sectionCreateEditField.value)
        if(data.success) {

            let section_list = await getSectionMasterList()
            updateSectionListUI(section_list, sectionListUI)
            addNotificationToQeue("alert-success", data.message)

        }else {
            addNotificationToQeue("alert-danger", data.message)
        }
    }
    
})

createTeacherModalTrigger.addEventListener("click", (e)=>{
    // clear fields
    teacherCreateEditFirstnameField.value = ""
    teacherCreateEditLastnameField.value = ""
    teacherCreateEditMiddlenameField.value = ""
    teacherCreateEditSuffixField.value = ""
    // clear id
    teacherCreateEditData.id = ""
    $("#teacher-create-edit-modal").modal('show')
})
closeTeacherModalTrigger.addEventListener("click", (e)=>{
    $("#teacher-create-edit-modal").modal('hide')
})
teacherSaveButton.addEventListener("click", async (e)=>{
    
    if(teacherCreateEditData.id.length > 0) {

        // edit information
        let id = teacherCreateEditData.id
        let lastname = teacherCreateEditLastnameField.value
        let firstname = teacherCreateEditFirstnameField.value
        let middlename = teacherCreateEditMiddlenameField.value
        let suffix = teacherCreateEditSuffixField.value

        if(lastname.trim().length <= 0 || firstname.trim().length <= 0 || middlename.trim().length <= 0) {

            addNotificationToQeue("alert-warning", "Please fill out the teacher's information.")
            teacherCreateEditLastnameField.focus()
            return false

        }

        let result = await  updateTeacher(id, lastname, firstname, middlename, suffix)

        if(result.success) {
            
            addNotificationToQeue("alert-success", result.message)
            let teacher_list = await getTeachersMasterList()
            updateTeacherListUI(teacher_list, teacherListUI)

        } else {

            addNotificationToQeue("alert-danger", result.message)

        }

    } else {

        // add new teacher
        let lastname = teacherCreateEditLastnameField.value
        let firstname = teacherCreateEditFirstnameField.value
        let middlename = teacherCreateEditMiddlenameField.value
        let suffix = teacherCreateEditSuffixField.value

        if(lastname.trim().length <= 0 || firstname.trim().length <= 0 || middlename.trim().length <= 0) {

            addNotificationToQeue("alert-warning", "Please fill out the teacher's information.")
            teacherCreateEditLastnameField.focus()
            return false

        }

        let result = await addTeacher(lastname, firstname, middlename, suffix)

        if(result.success) {

            addNotificationToQeue("alert-success", result.message)
            teacherCreateEditFirstnameField.value = ""
            teacherCreateEditLastnameField.value = ""
            teacherCreateEditMiddlenameField.value = ""
            teacherCreateEditSuffixField.value = ""
            // focus first field
            teacherCreateEditLastnameField.focus()
            // update ui
            let teacher_list = await getTeachersMasterList()
            updateTeacherListUI(teacher_list, teacherListUI)

        } else {

            addNotificationToQeue("alert-danger", result.message)

        }

    }
    
})
teacherListUI.addEventListener("click", async (e)=>{

    if(e.target.classList.contains("list-group-item")) {

        let activeEl = teacherListUI.querySelector(".list-group-item.active")
        if(activeEl != null) {
            activeEl.classList.remove('active')
        }
        e.target.classList.add('active')

        classAdviserInputField.value = e.target.dataset.empuid
    }

    if(e.target.classList.contains('edit-teacher')) {

        teacherCreateEditData.id = e.target.dataset.editteacherid
        teacherCreateEditLastnameField.value = e.target.dataset.lastname
        teacherCreateEditFirstnameField.value = e.target.dataset.firstname
        teacherCreateEditMiddlenameField.value = e.target.dataset.middlename
        teacherCreateEditSuffixField.value = e.target.dataset.suffix
        $("#teacher-create-edit-modal").modal('show')

    }

    if(e.target.classList.contains('delete-teacher')) {

        let msg = `Are you sure you want to delete teacher ${e.target.dataset.lastname}, ${e.target.dataset.firstname} ${e.target.dataset.middlename} ${e.target.dataset.suffix}'s information?`
        let confirmed = confirm(msg)
        if(confirmed) {

            // delete information
            let result = await deleteTeacher(e.target.dataset.deleteteacherid)
            if(result.success) {
                
                addNotificationToQeue("alert-success", result.messge)
                let teacher_list = await getTeachersMasterList()
                updateTeacherListUI(teacher_list, teacherListUI)

            } else {

                addNotificationToQeue("alert-warning", result.message)

            }
        }
    }

})

createSchoolyearModalTrigger.addEventListener("click", (e)=>{
    // clear schoolyearCreateEditField value
    schoolyearCreateEditField.value = ""
    // focus on schoolyearCreateEditField
    schoolyearCreateEditField.focus()
    // clear schoolyearCreateEditData object
    schoolyearCreateEditData.id = ""
    schoolyearCreateEditData.name = ""
    $("#schoolyear-create-edit-modal").modal('show')
})

closeSchoolyearModalTrigger.addEventListener("click", (e)=>{
    $("#schoolyear-create-edit-modal").modal('hide')
})

schoolyearSaveButton.addEventListener("click", async () => {

    // if sectionCreateEditData.id is empty means its a Create section operation
    if(schoolyearCreateEditData.id == "") {

        let name = schoolyearCreateEditField.value

        if(name.trim().length <= 0) {
            addNotificationToQeue("alert-warning", "Please fill out the schoolyear's name field.")
            schoolyearCreateEditField.focus()
            return false
        }

        let data = await createSchoolyear(name)
        if(data.success) {
            // get new list of section
            let schoolyear_list = await getSchoolyearMasterList()
            updateSchoolyearListUI(schoolyear_list, schoolyearListUI)
            // clear sectionCreateEditData object
            schoolyearCreateEditData.id = ""
            schoolyearCreateEditData.name = ""
            // notification 
            addNotificationToQeue("alert-success", data.message)
        }else {
            addNotificationToQeue("alert-danger", data.message)
        }

    }else {

        let name = schoolyearCreateEditField.value

        if(name.trim().length <= 0) {
            addNotificationToQeue("alert-warning", "Please fill out the schoolyear's name field.")
            schoolyearCreateEditField.focus()
            return false
        }

        schoolyearCreateEditData.name = name
        // edit operation
        let data = await updateSchoolyear(schoolyearCreateEditData.id, schoolyearCreateEditField.value)
        if(data.success) {

            let schoolyear_list = await getSchoolyearMasterList()
            updateSchoolyearListUI(schoolyear_list, schoolyearListUI)
            addNotificationToQeue("alert-success", data.message)

        }else {
            addNotificationToQeue("alert-danger", data.message)
        }
    }
    
})


// DATA DISPLAY FUNCTIONS

// Update the students list on the studentListUI element
function updateStudentListUI(student_list, studentListUI) {

    // reset stduentListUiIndex
    studentListUiIndex = []
    let list = ''
    let uiIndex = 0

    for(let index in student_list.data) {
        list += `<li href="#" class="list-group-item" data-index=${uiIndex} data-lrn="${student_list.data[index].lrn.trim()}">
            ${student_list.data[index].lastname}, ${student_list.data[index].firstname} ${student_list.data[index].middlename} ${student_list.data[index].suffix}
            <div class="btn-group" role="group" aria-label="">
                <a href="${baseUrl}student/edit/${student_list.data[index].id}" type="button" class="btn btn-default btn-xs"><i class="fa-solid fa-edit"></i></a>
            </div>
        </li>`
        uiIndex++
        let str = `${student_list.data[index].lastname}, ${student_list.data[index].firstname} ${student_list.data[index].middlename} ${student_list.data[index].suffix}`
        // transform to lower case the string which will basis of searchStudent function
        studentListUiIndex.push(str.toLocaleLowerCase())
    }
    // update ui
    studentListUI.innerHTML = list
}

// Search for a student in the list. and show the student and hide the others
function searchStudent(name) {

    // transform string case to lower to avoid case sensitivity cause its not a password
    let str = name.toLocaleLowerCase()

    for(let i = 0; i < studentListUiIndex.length; i++) {
        if(!studentListUiIndex[i].includes(str)) {
            // display hide the value that does not have the same string as the str
            let element = document.querySelector(`[data-index='${i}'`)
            element.setAttribute("style","display:none;")
        }else{
            // show the value with the same string as the str
            let element = document.querySelector(`[data-index='${i}'`)
            element.setAttribute("style","")
        }
    }
    
}

function updateLevelListUI(level_list, levelListUI) {

    let list = ''

    for(let index in level_list.data) {
        list += `<li class="list-group-item" data-id=${level_list.data[index].id} style="cursor:pointer;"> ${level_list.data[index].name}
            <div class="btn-group" role="group" aria-label="">
                <button data-editlevelid="${level_list.data[index].id}" type="button" class="btn btn-default btn-xs edit-level"><i class="fa-solid fa-edit"></i></button>
                <button data-deletelevelid="${level_list.data[index].id}" type="button" class="btn btn-default btn-xs delete-level"><i class="fa-solid fa-trash"></i></button>
            </div>
        </li>`
    }
    // update ui
    levelListUI.innerHTML = list
}

function updateSectionListUI(section_list, sectionListUI) {

    let list = ''

    for(let index in section_list.data) {
        list += `<li class="list-group-item" data-id=${section_list.data[index].id}>${section_list.data[index].name}
            <div class="btn-group" role="group" aria-label="">
                <button data-editsectionid="${section_list.data[index].id}" type="button" class="btn btn-default btn-xs edit-section"><i class="fa-solid fa-edit"></i></button>
                <button data-deletesectionid="${section_list.data[index].id}" type="button" class="btn btn-default btn-xs delete-section"><i class="fa-solid fa-trash"></i></button>
            </div>
        </li>`
    }
    // update ui
    sectionListUI.innerHTML = list
}

function updateTeacherListUI(teacher_list, teacherListUI) {

    let list = ''
    let suffix = ""
    for(let index in teacher_list.data) {
        suffix = teacher_list.data[index].suffix == 'undefined' ? "" : teacher_list.data[index].suffix
        list += `<li class="list-group-item" data-id=${teacher_list.data[index].id} data-empuid=${teacher_list.data[index].empuid} > ${teacher_list.data[index].lastname}, ${teacher_list.data[index].firstname} ${teacher_list.data[index].middlename} ${suffix}
            <div class="btn-group" role="group" aria-label="">
                <button 
                    data-editteacherid="${teacher_list.data[index].id}" 
                    data-lastname="${teacher_list.data[index].lastname}" 
                    data-firstname="${teacher_list.data[index].firstname}" 
                    data-middlename="${teacher_list.data[index].middlename}" 
                    data-suffix="${teacher_list.data[index].suffix}" 
                type="button" class="btn btn-default btn-xs edit-teacher"><i class="fa-solid fa-edit"></i></button>

                <button 
                    data-deleteteacherid="${teacher_list.data[index].id}" 
                    data-lastname="${teacher_list.data[index].lastname}" 
                    data-firstname="${teacher_list.data[index].firstname}" 
                    data-middlename="${teacher_list.data[index].middlename}" 
                    data-suffix="${teacher_list.data[index].suffix}" 
                type="button" class="btn btn-default btn-xs delete-teacher"><i class="fa-solid fa-trash"></i></button>
            </div>
        </li>`
    }
    // update ui
    teacherListUI.innerHTML = list
}

function updateSchoolyearListUI(schoolyear_list, schoolyearListUI) {

    let list = ''

    for(let index in schoolyear_list.data) {
        list += `<li href="#" class="list-group-item" data-id=${schoolyear_list.data[index].id}>${schoolyear_list.data[index].name}
            <div class="btn-group" role="group" aria-label="">
                <button data-editschoolyearid="${schoolyear_list.data[index].id}" type="button" class="btn btn-default btn-xs edit-schoolyear"><i class="fa-solid fa-edit"></i></button>
                <button data-deleteschoolyearid="${schoolyear_list.data[index].id}" type="button" class="btn btn-default btn-xs delete-schoolyear"><i class="fa-solid fa-trash"></i></button>
            </div>
        </li>`
    }
    // update ui
    schoolyearListUI.innerHTML = list
}

async function updateClassMasterListUI(classes_list, classListUI) {

    let list = ''
    let levelNames = {}
    let sectionNames = {}
    let adviserNames = {}

    let levels = await getLevelMasterList()
    let sections = await getSectionMasterList()
    let advisers = await getTeachersMasterList()
    
    if(Object.keys(levels.data).length > 0) {
        for(let i in levels.data) {
            levelNames[levels.data[i].id] = levels.data[i].name
        }
    }

    if(Object.keys(sections).length > 0) {
        for(let i in sections.data) {
            sectionNames[sections.data[i].id] = sections.data[i].name
        }
    }

    if(Object.keys(advisers).length > 0) {
        for(let i in advisers.data) {
            adviserNames[advisers.data[i].empuid] = `${advisers.data[i].lastname}, ${advisers.data[i].firstname} ${advisers.data[i].middlename} ${advisers.data[i].suffix}`
        }
    }

    if(Object.keys(classes_list.data).length > 0) {
        for(let index in classes_list.data) {
            list += `<li class="list-group-item" 
            data-id=${classes_list.data[index].id} 
            data-classname='${levelNames[classes_list.data[index].level_id]} ${sectionNames[classes_list.data[index].section_id]}' 
            data-adviser='${adviserNames[classes_list.data[index].empuid] == undefined ? "" : adviserNames[classes_list.data[index].empuid]}' >

                <div class="class-name-and-adviser-label">
                    ${levelNames[classes_list.data[index].level_id]} 
                    ${sectionNames[classes_list.data[index].section_id]}
                    <p class="">Adviser: ${adviserNames[classes_list.data[index].empuid] == undefined ? "" : adviserNames[classes_list.data[index].empuid]}</p>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs edit-class" data-classid=${classes_list.data[index].id} 
                        data-classadviser='${adviserNames[classes_list.data[index].empuid] == undefined ? "" : adviserNames[classes_list.data[index].empuid]}'
                        data-empuid='${classes_list.data[index].empuid}'
                        ><i class="fa-solid fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-xs delete-class" data-classid=${classes_list.data[index].id}><i class="fa-solid fa-trash"></i></button>
                </div>

            </li>`
        }
    }
    // update ui
    classListUI.innerHTML = list
}

function updateClassStudentUI(studentsInClassLrn, classStudentUI) {

    let list = ''
    let studentName = ''
    for(let i in studentsInClassLrn) {
        studentName = studentListUI.querySelector(`[data-lrn='${studentsInClassLrn[i]}']`).innerText
        list += `<li class="list-group-item">${studentName} 
                <button type="button" class="btn btn-danger btn-xs remove-student-from-class" data-removelrn='${studentsInClassLrn[i]}'><i class="fa-solid fa-trash"></i></button>    
        </li>`
    }
    // update ui
    classStudentUI.innerHTML = list
}

function updateClassNameField() {
    classNameFieldUI.value = `${className.level} ${className.section}`
}

function updateClassStudentOfSchoolyearUI() {
    classStudentOfSchoolyearUI.innerHTML = `${classStudents.class} Students; S.Y. ${classStudents.schoolyear}`
    classAdviserOfSchoolyearUI.innerHTML = `Adviser: ${classStudents.adviser}`
}

function updateLevelCreateEditModalUI() {
    levelCreateEditField.value = levelCreateEditData.name
}

function updateSectionCreateEditModalUI() {
    sectionCreateEditField.value = sectionCreateEditData.name
}

function updateSchoolyearCreateEditModalUI() {
    schoolyearCreateEditField.value = schoolyearCreateEditData.name
}