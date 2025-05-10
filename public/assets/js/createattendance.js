let schoolyearDropdown = document.querySelector("#select-schoolyear-dropdown")
let classDropdown = document.querySelector("#select-class-dropdown")
let getAttendanceBtn = document.querySelector("#get-attendance-btn")

let monthlyAttendanceBtn = document.querySelector("#show-monthly-attendance-table-btn")
// let dailyAttendanceBtn = document.querySelector("#show-daily-attendance-table-btn")

let daysPresentBtn = document.querySelector("#show-days-present-inputs-btn")
let daysTardyBtn = document.querySelector("#show-days-tardy-inputs-btn")

let attendanceTable = document.querySelector("#attendance-table")

let loader = document.querySelector("#loader")

// total number of students in a class
// this is also the total number of rows
let totalStudents = 0;
let totalRows = 0

// total number of months
// total number of cols
let totalCols = 0
let tableheaders = 0

// Input field initial coordinate
let currentRow = 0
let currentCol = 0

// attendance type
let attendanceType = 1; // 1 present | 0 tardy

// Monthly or Daily Attendance Operations?
let operation = 0

monthlyAttendanceBtn.addEventListener("click", (e)=>{

    // add active class to indicate which button or operation is currently operation
    e.target.classList.add('active')
    // dailyAttendanceBtn.classList.remove('active')

    // empty table
    attendanceTable.innerHTML = ''

})
// dailyAttendanceBtn.addEventListener("click", (e)=>{

//     // add active class to indicate which button or operation is currently operation
//     e.target.classList.add('active')
//     monthlyAttendanceBtn.classList.remove('active')

//     // empty table
//     attendanceTable.innerHTML = ''

// })

daysPresentBtn.addEventListener("click", (e)=>{

    e.target.classList.add('active')
    daysTardyBtn.classList.remove('active')

    attendanceType = 1
    // empty table
    attendanceTable.innerHTML = ''

})
daysTardyBtn.addEventListener("click", (e) => {

    e.target.classList.add('active')
    daysPresentBtn.classList.remove('active')

    attendanceType = 0
    // empty table
    attendanceTable.innerHTML = ''

})


// 
getAttendanceBtn.addEventListener("click", async (e) => {

    // show loader
    loader.setAttribute("style","display:flex;")

    // get schoolyear id
    let schoolyear_id = schoolyearDropdown.value

    if(schoolyear_id == "") {
        addNotificationToQeue("alert-warning", "Please select a schoolyear.")
        loader.setAttribute("style","display:none;")
        return false
    }

    // get class id
    let class_id = classDropdown.value

    if(class_id == "") {
        addNotificationToQeue("alert-warning", "Please a class.")
        loader.setAttribute("style","display:none;")
        return false
    }

    // Get class
    let studentclass = await getSchoolyearClassStudentList(class_id, schoolyear_id)

    totalStudents = studentclass.data.length
    totalRows = studentclass.data.length

    if(studentclass.data.length <= 0) {
        // hide loader
        loader.setAttribute("style","display:none;")

        // show no students in this class for this school year
        let msg = `<tbody>
            <tr>
                <td>
                    <div class="alert alert-info text-center" style="margin-bottom:0;"><strong>There are no students in this class.</strong></div>
                </td>
            </tr>
        </tbody>`
        attendanceTable.innerHTML = msg


        addNotificationToQeue("alert-info", "There are no students in this class for this school year.")
        return false
    }

    // get school days
    tableheaders = await getSchoolyearSchoolDays(schoolyear_id)
    totalCols = tableheaders.data.length

    // tabulate data
    await updateAttendanceTableContent(studentclass.data, tableheaders.data)
    // hide loader
    loader.setAttribute("style","display:none;")

    // set the currentRow and currentCol to 1 and focus on the first input
    if(studentclass.data.length > 0) {
        currentCol = 1
        currentRow = 1
        focusInput()
    }
})

// 
attendanceTable.addEventListener("keyup", async (e) => {

    if(e.target.classList.contains('form-control') && (e.key === 'Enter' || e.keyCode === 13)) {

        if(e.target.dataset.id != undefined) {
            
            let result = await saveMonthlyAttendanceById(e.target.dataset.id, attendanceType == 1 ? "days_present" : "days_tardy", e.target.value)

            if(result.success) {

                addNotificationToQeue("alert-success", result.message)

            } else {

                addNotificationToQeue("alert-danger", result.message)

            }

        } else {
            
            let result = await saveMonthlyAttendance(e.target.dataset.lrn, e.target.dataset.schoolyearid, e.target.dataset.schooldaysid, attendanceType == 1 ? "days_present" : "days_tardy", e.target.value)

            if(result.success) {

                addNotificationToQeue("alert-success", result.message)
                e.target.setAttribute('data-id', result.data)

            } else {

                addNotificationToQeue("alert-danger", result.message)

            }

        }

        // move to next input
        currentCol++
        console.log(currentRow)
        console.log(currentCol)
        if(currentCol <= totalCols) {
            focusInput()
        }
        if(currentCol > totalCols && currentRow < totalRows) {
            currentCol = 1
            currentRow++
            focusInput()
        }
        // if at the end of inputs return to the first input
        if(currentCol > totalCols && currentRow >= totalRows) {
            currentCol = 1
            currentRow = 1
            focusInput()
        }
    }

    //ArrowDown
    if(e.keyCode == 40 && (currentRow < totalRows) ) {
        currentRow++
        focusInput()
    }
    // ArrowRight
    if(e.keyCode == 39 && (currentCol < totalCols)) {
        currentCol++
        focusInput()
    }
    //ArrowUp
    if(e.keyCode == 38 && (currentRow > 1)) {
        currentRow--
        focusInput()
    }
    // ArrowLeft
    if(e.keyCode == 37 && (currentCol > 1)) {
        currentCol--
        focusInput()
    }
    // Tab
    if(e.keyCode == 9) {
        currentRow = document.activeElement.dataset.row
        currentCol = document.activeElement.dataset.col
    }

})

attendanceTable.addEventListener("click", (e) => {
    if(e.target.nodeName == "INPUT") {
        currentCol = document.activeElement.dataset.col
        currentRow = document.activeElement.dataset.row
    }
})

async function updateAttendanceTableContent(student, headers)
{   
    console.log(headers.length)
    console.log(student.length)
    let header_rows = `<thead><tr><th>Name</th>`
    let input_fields = ''
    let months = []
    for(let i in headers) {
        header_rows += `<th>${headers[i].month.substring(0, 3).toUpperCase()}</th>`
        input_fields += `<td><input type="text" placeholder=""  class="form-control" data-id="${headers[i].id}" data-schoolyearid="${headers[i].schoolyear_id}" /"></td>`
        months.push(headers[i].id)
    }
    header_rows += '</tr></thead>'

    let rows = `<tbody>`

    let rowNo = 1
    
    for(let i in student) {
        rows += `<tr><td>${student[i].lastname}, ${student[i].firstname} ${student[i].middlename} ${student[i].suffix}</td>`
        
        rows += attendanceType ? await tabulateMonthlyAttendance(student[i].lrn, schoolyearDropdown.value, months, "days_present", rowNo) : await tabulateMonthlyAttendance(student[i].lrn, schoolyearDropdown.value, months, "days_tardy", rowNo) 

        rows += `</tr>`

        rowNo++
    }
    rows += `</tbody>`

    attendanceTable.innerHTML = header_rows+=rows
}

async function tabulateMonthlyAttendance(lrn, schoolyear, months, type, row)
{

    let result = await getMonthlyAttendance(lrn, schoolyear, months)
    let data = ''
    let col = 1

    for(let i in months) {
        let color = ''
        let value
        if(result.data.hasOwnProperty(months[i])) {

            value = result.data[months[i]][type] != null ? result.data[months[i]][type] : ''
            color = result.data[months[i]][type] != null ? '' : "style='background: #ff000040';"

            data += `<td><input type="text" placeholder="" ${color} class="form-control" data-id="${result.data[months[i]].id}" value="${value}" data-row="${row}" data-col="${col}" id="_${row}_${col}" /></td>`

        }else {
            color = 'style="background: #ff000040";'
            data += `<td><input type="text" placeholder="" ${color} class="form-control" data-lrn="${lrn}" data-schoolyearid="${schoolyear}" data-schooldaysid="${months[i]}" value="" data-row="${row}" data-col="${col}" id="_${row}_${col}" /></td>`
        }
        
        col++
    }

    return data
}

function focusInput() {
    attendanceTable.querySelector(`#_${currentRow}_${currentCol}`).focus()
}