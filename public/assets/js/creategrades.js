let schoolyearOptionsInput = document.querySelector("#select-schoolyear-dropdown")
let classOptionsInput = document.querySelector("#select-class-dropdown")
let curriculumOptionsInput = document.querySelector("#select-curriculum-dropdown")
let strandOptionsInput = document.querySelector("#select-strand-dropdown")
let semesterOptionsInput = document.querySelector("#select-semester-dropdown")
let periodOptionsInput = document.querySelector("#select-period-dropdown")
let startQuery = document.querySelector("#start-query")
// let tabbingCheckbox = document.querySelector("#toggle-tabbing")
// let tabbingDescription = document.querySelector("#tabbing-description")

// let generateReportCardBtn = document.querySelector("#generate-report-card")
// let selectAllStudents = document.querySelector("#select-all-students")
// let selectedAll = true
// let selectedLrns = []

let closeDialogBtn = document.querySelector("#close-download-dialog-modal")
let downloadDialogUI = document.querySelector("#download-dialog-ui")

let tableSubjectRow = document.querySelector("#table-subjects-row")
let tableStudentsGradeRows = document.querySelector("#table-students-grade-row")

let gradeCol = 0 // x length
let gradeRow = 0 // y length

let gradeXCoor = 1 // current x axis
let gradeYCoor = 1 // current y axis

// Subject|Traits Buttons - Top menu on the left;
let showSubjectTableBtn = document.querySelector("#show-subject-grades-table-btn")
let showTraitTableBtn = document.querySelector("#show-trait-grades-table-btn")
// Subject|Traits Tables
let SubjectsTable = document.querySelector('#subject-grades-table')
let TraitsTable = document.querySelector('#trait-grades-table')

let tableActive = 0 // if 0 subject tables are active: 1 trait tables are active

let loader = document.querySelector("#loader")

let queryIDS = {
    "schoolyear_id": "",
    "class_id": "",
    "curriculum_id": "",
    "strand_id": "",
    "semester_id": "",
    "period_id": ""
}

let studentsMasterList = new Map()
let subjectMasterList = new Map()
let traitMasterList = new Map()

let grades = new Map();

schoolyearOptionsInput.addEventListener("change", (e)=> {
    queryIDS.schoolyear_id = e.target.value
})

classOptionsInput.addEventListener("change", (e)=> {
    queryIDS.class_id = e.target.value
})

curriculumOptionsInput.addEventListener("change", (e)=> {
    queryIDS.curriculum_id = e.target.value
})

strandOptionsInput.addEventListener("change", (e)=> {
    queryIDS.strand_id = e.target.value
})

semesterOptionsInput.addEventListener("change", (e)=> {
    queryIDS.semester_id = e.target.value
})

periodOptionsInput.addEventListener("change", (e)=> {
    queryIDS.period_id = e.target.value
})

startQuery.addEventListener("click", async (e)=> {
    // make sure all dropdown selection has a selected value
    for(const [key, value] of Object.entries(queryIDS)) {
        if(value.length <= 0) {
            addNotificationToQeue("alert-danger", "Please select required dropdown options.")
            return false
        }
    }

    // show loader
    loader.setAttribute("style","display:flex;")

    let students = await getSchoolyearClassStudentList(queryIDS.class_id, queryIDS.schoolyear_id)

    // query base on the activeTable if
    
    let curriculumSubjects
    let curriculumTraits

    // get subjects|traits of the selectedSemester
    let sfts = []

    // table subjects|traits row
    let tsr = "<th>Name</th>"

    switch(tableActive) {
        case 0:

            curriculumSubjects = await getCurriculumSubjects(queryIDS.curriculum_id, queryIDS.strand_id)
            
            // total number of subjects is total number columns
            gradeCol = Object.keys(curriculumSubjects.data).length

            // subjects header
            for(let i in curriculumSubjects.data) {
                if(curriculumSubjects.data[i].semester_id == queryIDS.semester_id){
                    sfts.push(curriculumSubjects.data[i].subject_id)
                    tsr += `<th data-toggle="tooltip" data-placement="bottom" title="${subjectMasterList.get(curriculumSubjects.data[i].subject_id).name}">${subjectMasterList.get(curriculumSubjects.data[i].subject_id).name.substr(0, 3).toUpperCase()}</th>`    
                }
            }
            break

        case 1:
            
            curriculumTraits = await getCurriculumTraits(queryIDS.curriculum_id, queryIDS.strand_id)

            // total number of traits is total number columns
            gradeCol = Object.keys(curriculumTraits.data).length

            // traits header
            for(let i in curriculumTraits.data) {
                if(curriculumTraits.data[i].semester_id == queryIDS.semester_id){
                    sfts.push(curriculumTraits.data[i].trait_id)
                    tsr += `<th data-toggle="tooltip" data-placement="bottom" title="${traitMasterList.get(curriculumTraits.data[i].trait_id).decription}">${traitMasterList.get(curriculumTraits.data[i].trait_id).description}</th>`    
                }
            }
            break

        default:
            break
    }

    // table students grade rows
    let tsgr = ""
    let totalStudents = Object.keys(students.data).length
    let tabIndex = 1

    // totalStudents is the total number of row
    gradeRow = totalStudents

    for(let i in students.data) {
        let ti = tabIndex
        tsgr += `<tr>`
        // tsgr += `<td><input type="checkbox" name="student-lrn" value="${students.data[i].lrn}" class="student-checkbox-lrn"/></td>`
        tsgr += `<td>${studentsMasterList.get(students.data[i].lrn).lastname}, ${studentsMasterList.get(students.data[i].lrn).firstname} ${studentsMasterList.get(students.data[i].lrn).middlename} ${studentsMasterList.get(students.data[i].lrn).suffix}</td>`
            
            // in a single query all grades of all subject of the student is returned.
            tsgr += tableActive == 0 ? await studentSubjectsGradeUI(students.data[i].lrn, sfts, queryIDS.schoolyear_id, queryIDS.semester_id, queryIDS.period_id, ti, totalStudents) : await studentTraitsGradeUI(students.data[i].lrn, sfts, queryIDS.schoolyear_id, queryIDS.semester_id, queryIDS.period_id, ti, totalStudents)

        tsgr += `</tr>`
        tabIndex++
    }

    tableSubjectRow.innerHTML = tsr
    tableStudentsGradeRows.innerHTML = tsgr

    // hide loader
    loader.setAttribute("style","display:none;")
})

tableStudentsGradeRows.addEventListener("keyup", async (e)=> {
    
    if(e.target.classList.contains('form-control') && (e.key === 'Enter' || e.keyCode === 13)) {

        let lrn = e.target.dataset.lrn
        let schoolyearid = e.target.dataset.schoolyear
        let classid = queryIDS.class_id
        let curriculumid = queryIDS.curriculum_id
        let strandid = queryIDS.strand_id
        let semesterid = e.target.dataset.semester
        let periodid = e.target.dataset.period
        // if tableActive is 0 it is for subject | if tableActive is 1 it is for trait
        let id = tableActive == 0 ? e.target.dataset.subjectid : e.target.dataset.traitid
        let grade = e.target.value
       
        let data = tableActive == 0 ? await saveSubjectGrade(lrn, schoolyearid, classid, curriculumid, strandid, semesterid, periodid, id, grade) : await saveTraitGrade(lrn, schoolyearid, classid, curriculumid, strandid, semesterid, periodid, id, grade)
        
        if(data.success) {
            // notify
            addNotificationToQeue("alert-success", data.message)
        }else {
            // notify
            addNotificationToQeue("alert-danger", data.message)
        }


        // gradeXCoor++
        // if(gradeXCoor <= gradeCol ) {
        //     focusInput()
        // }
        // if(gradeXCoor > gradeCol && gradeYCoor < gradeRow) {
        //     gradeXCoor = 1
        //     gradeYCoor++
        //     focusInput()
            
        // }
        // // if on lower right end input transfer to upper left end input
        // if(gradeXCoor > gradeCol && gradeYCoor >= gradeRow) {
        //     gradeYCoor = 1
        //     gradeXCoor = 1
        //     focusInput()
        // }
        
        gradeYCoor++
        if(gradeYCoor <= gradeRow) {
            focusInput()
        }

        if(gradeYCoor > gradeRow && gradeXCoor < gradeCol) {
            gradeYCoor = 1
            gradeXCoor++
            focusInput()
            
        }

        if(gradeYCoor > gradeRow && gradeXCoor >= gradeCol) {
            gradeXCoor = 1
            gradeYCoor = 1
            focusInput()
        }
    }
    //ArrowDown
    if(e.keyCode == 40 && (gradeYCoor < gradeRow) ) {
        console.log(gradeYCoor)
        gradeYCoor++

        focusInput()
    }
    // ArrowRight
    if(e.keyCode == 39 && (gradeXCoor < gradeCol)) {
        console.log(gradeXCoor)
        gradeXCoor++

        focusInput()
    }
    //ArrowUp
    if(e.keyCode == 38 && (gradeYCoor > 1)) {
        console.log(gradeYCoor)
        gradeYCoor--

        focusInput()
    }
    // ArrowLeft
    if(e.keyCode == 37 && (gradeXCoor > 1)) {
        console.log(gradeXCoor)
        gradeXCoor--

        focusInput()
    }
    // Tab
    if(e.keyCode == 9) {
        gradeYCoor = document.activeElement.dataset.row
        gradeXCoor = document.activeElement.dataset.col
    }
})

function focusInput()
{
    document.querySelector(`#_${gradeYCoor}_${gradeXCoor}`).focus()
}

tableStudentsGradeRows.addEventListener("click", (e)=>{

    if(e.target.classList.contains('student-checkbox-lrn')) {
        
        if(e.target.checked) {
            // add to selected lrn
            selectedLrns.push(e.target.value)
        }else{
            // remove from selected lrns
            let index = selectedLrns.indexOf(e.target.value)
            selectedLrns.splice(index,1)
        }
    }

    if(e.target.nodeName == "INPUT") {
        gradeYCoor = document.activeElement.dataset.row
        gradeXCoor = document.activeElement.dataset.col
    }
})

// selectAllStudents.addEventListener("click", (e)=>{
//     let inputs = document.querySelectorAll("input[name='student-lrn']")
//     if(inputs.length > 0) {
//         let lrn = ""
//         inputs.forEach((input)=>{
//             lrn = input.value
//             if(input.checked) {
//                 // if its already true
//                 input.checked = false
//                 // if false remove it from the selectedLrns
//                 if(removeFromSelectedLRN(lrn)) {
//                     addNotificationToQeue("alert-success", "Lrn has been removed.")
//                 } else {
//                     addNotificationToQeue("alert-danger", "Unable to remove lrn.")
//                 }
//                 // 
//             }else{
//                 // if its already false
//                 input.checked = true
//                 // if true add to selectedLrns
//                 selectedLrns.push(lrn)
//             }
//         })
//     }
// })

// generateReportCardBtn.addEventListener("click",async  (e)=>{

//     if(selectedLrns.length <= 0) {
//         // dont proceed in generating a report card if no student is selected.
//         addNotificationToQeue("alert-warning", "Please select a number of students.")
//         return false
//     }
    
//     // show loader
//     loader.setAttribute("style","display:flex;")
//     // get all student lrn
//     let result = await generateReportCard(queryIDS.schoolyear_id, queryIDS.class_id, queryIDS.curriculum_id, queryIDS.strand_id, selectedLrns)
    
//     if(result.success) {

//         addNotificationToQeue("alert-success", result.message)
//          // show loader
//         loader.setAttribute("style","display:none;")

//         $("#download-dialog").modal('show')
//         // show the download link
//         link = result.data
//         // element
//         let element = `<div class="alert alert-success"><a href='${link}' >Click to download report card.</a></div>`
//         downloadDialogUI.innerHTML = element

//     }else{

//          // hide loader
//         loader.setAttribute("style","display:none;")
//         addNotificationToQeue("alert-danger", result.message)

//     }

// })

closeDialogBtn.addEventListener("click", (e)=>{
    $("#download-dialog").modal('hide')
})

// Tabbing Toggle
// tabbingCheckbox.addEventListener("click", (e)=> {

//     if(e.target.checked) {

//         tabbingDescription.value = "Vertical Tabbing"

//     } else {

//         tabbingDescription.value = "Horizontal Tabbing"

//     }

// })

function removeFromSelectedLRN(lrn) 
{
    // get index of the value
    let index = selectedLrns.indexOf(lrn)
    // remove 
    let deleteItemArr = selectedLrns.splice(index, 1)
    return deleteItemArr.length > 0 ? true : false
}

async function studentSubjectsGradeUI(lrn, subjectsarr, schoolyearid, semesterid, periodid, tabindex, totalStudents)
{

    let result = await getStudentSubjectsGrade(lrn, schoolyearid, semesterid, periodid, subjectsarr)
    
    let inputGrades = ""
    let ti = tabindex
    let row = tabindex
    let col = 1
    let color = ''

    // if(tabbingCheckbox.checked) {

        for(let i in subjectsarr) {
            color = result.data.hasOwnProperty(subjectsarr[i]) ? '' : "style='background: #ff000040';"
            inputGrades += result.data.hasOwnProperty(subjectsarr[i]) ? `<td><input class="form-control" type="text" id="_${row}_${col}" data-row="${row}" data-col="${col}" ${color} data-lrn=${lrn} data-schoolyear=${schoolyearid} data-semester=${semesterid} data-period=${periodid} data-subjectid=${subjectsarr[i]} value="${result.data[subjectsarr[i]].grade}" maxlength="8" size="8" /></td>` : `<td><input class="form-control" type="text" id="_${row}_${col}" data-row="${row}" data-col="${col}" ${color} data-lrn=${lrn} data-schoolyear=${schoolyearid} data-semester=${semesterid} data-period=${periodid} data-subjectid=${subjectsarr[i]} value="" maxlength="8" size="8"/></td>`
            ti += totalStudents
            col++
        }

    // } 
    //else {
    //     for(let i in subjectsarr) {
    //         color = result.data.hasOwnProperty(subjectsarr[i]) ? '' : "style='background: #ff000040';"
    //         inputGrades += result.data.hasOwnProperty(subjectsarr[i]) ? `<td><input class="form-control" type="text" id="_${row}${col}" data-row="${row}" data-col="${col}" ${color} data-lrn=${lrn} data-schoolyear=${schoolyearid} data-semester=${semesterid} data-period=${periodid} data-subjectid=${subjectsarr[i]} value="${result.data[subjectsarr[i]].grade}" maxlength="8" size="8" /></td>` : `<td><input class="form-control" type="text" ${color} data-lrn=${lrn} data-schoolyear=${schoolyearid} data-semester=${semesterid} data-period=${periodid} data-subjectid=${subjectsarr[i]} value="" maxlength="8" size="8"/></td>`
    //         ti += totalStudents
    //     }
    // }

    return inputGrades
}

async function studentTraitsGradeUI(lrn, traitsarr, schoolyearid, semesterid, periodid, tabindex, totalStudents)
{

    let result = await getStudentTraitsGrade(lrn, schoolyearid, semesterid, periodid, traitsarr)
    
    let inputGrades = ""
    let ti = tabindex
    let row = tabindex
    let col = 1
    let color = ''
    for(let i in traitsarr) {
        color = result.data.hasOwnProperty(traitsarr[i]) ? '' : "style='background: #ff000040';"
        inputGrades += result.data.hasOwnProperty(traitsarr[i]) ? `<td><input class="form-control" type="text" id="_${row}_${col}" data-row="${row}" data-col="${col}" ${color} data-lrn=${lrn} data-schoolyear=${schoolyearid} data-semester=${semesterid} data-period=${periodid} data-traitid=${traitsarr[i]} value="${result.data[traitsarr[i]].grade}" maxlength="8" size="8" /></td>` : `<td><input class="form-control" type="text"  id="_${row}_${col}" data-row="${row}" data-col="${col}" ${color} data-lrn=${lrn} data-schoolyear=${schoolyearid} data-semester=${semesterid} data-period=${periodid} data-traitid=${traitsarr[i]} value="" maxlength="8" size="8"/></td>`
        ti += totalStudents
        col++
    }

    return inputGrades
}

showSubjectTableBtn.addEventListener("click", (e) => {

    e.target.classList.add('active')
    showTraitTableBtn.classList.remove('active')
    tableActive = 0

    // empty 
    tableSubjectRow.innerHTML = ""
    tableStudentsGradeRows.innerHTML = ""

    addNotificationToQeue("alert-info", "Switch to SUBJECT OPERATIONS")
})

showTraitTableBtn.addEventListener("click", (e) => {

    e.target.classList.add('active')
    showSubjectTableBtn.classList.remove('active')
    tableActive = 1

    // empty 
    tableSubjectRow.innerHTML = ""
    tableStudentsGradeRows.innerHTML = ""

    addNotificationToQeue("alert-info", "Switch to TRAIT OPERATIONS")
})



// on window load
window.addEventListener("load", async (e)=> {

    // get student master list
    let students = await getStudentMasterlist()
    if(Object.keys(students.data).length > 0) {
        for(let index in students.data) {
            studentsMasterList.set(students.data[index].lrn, students.data[index])
        }
    }
    // get subject master list
    let subjects = await getSubjectMasterList()
    if(Object.keys(subjects.data).length > 0) {
        for(let index in subjects.data) {
            subjectMasterList.set(subjects.data[index].id, subjects.data[index])
        }
    }
    // get trait master list
    let traits = await getTraitMasterList()
    if(Object.keys(traits.data).length > 0) {
        for(let index in traits.data) {
            traitMasterList.set(traits.data[index].id, traits.data[index])
        }
    }

    // modal
    $("#download-dialog").modal({
        keyboard:true,
        backdrop:"static"
    })

})