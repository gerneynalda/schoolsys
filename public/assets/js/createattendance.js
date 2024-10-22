let schoolyearDropdown = document.querySelector("#select-schoolyear-dropdown")
let classDropdown = document.querySelector("#select-class-dropdown")
let getAttendanceBtn = document.querySelector("#get-attendance-btn")

let monthlyAttendanceBtn = document.querySelector("#show-monthly-attendance-table-btn")
let dailyAttendanceBtn = document.querySelector("#show-daily-attendance-table-btn")

let daysPresentBtn = document.querySelector("#show-days-present-inputs-btn")
let daysTardyBtn = document.querySelector("#show-days-tardy-inputs-btn")

let attendanceTable = document.querySelector("#attendance-table")

let loader = document.querySelector("#loader")

// total number of students in a class
let totalStudents = 0;

// attendance type
let attendanceType = 1; // 1 present | 0 tardy

// Monthly or Daily Attendance Operations?
let operation = 0

monthlyAttendanceBtn.addEventListener("click", (e)=>{

    // add active class to indicate which button or operation is currently operation
    e.target.classList.add('active')
    dailyAttendanceBtn.classList.remove('active')

    // empty table
    attendanceTable.innerHTML = ''

})
dailyAttendanceBtn.addEventListener("click", (e)=>{

    // add active class to indicate which button or operation is currently operation
    e.target.classList.add('active')
    monthlyAttendanceBtn.classList.remove('active')

    // empty table
    attendanceTable.innerHTML = ''

})

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
    let tableheaders = await getSchoolyearSchoolDays(schoolyear_id)
    // tabulate data
    await updateAttendanceTableContent(studentclass.data, tableheaders.data)
    // hide loader
    loader.setAttribute("style","display:none;")

})

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

    }

})

async function updateAttendanceTableContent(student, headers)
{   
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
    let tabNo = 1
    for(let i in student) {
        rows += `<tr><td>${student[i].lastname}, ${student[i].firstname} ${student[i].middlename} ${student[i].suffix}</td>`
        
        rows += attendanceType ? await tabulateMonthlyAttendance(student[i].lrn, schoolyearDropdown.value, months, "days_present", tabNo) : await tabulateMonthlyAttendance(student[i].lrn, schoolyearDropdown.value, months, "days_tardy", tabNo) 

        rows += `</tr>`

        tabNo++
    }
    rows += `</tbody>`

    attendanceTable.innerHTML = header_rows+=rows
}

async function tabulateMonthlyAttendance(lrn, schoolyear, months, type, tabIndex)
{

    let result = await getMonthlyAttendance(lrn, schoolyear, months)
    let data = ''
    let index = tabIndex

    for(let i in months) {
        let color = ''
        let value
        if(result.data.hasOwnProperty(months[i])) {

            value = result.data[months[i]][type] != null ? result.data[months[i]][type] : ''
            color = result.data[months[i]][type] != null ? '' : "style='background: #ff000040';"

            data += `<td><input type="text" placeholder="" ${color} tabIndex=${index} class="form-control" data-id="${result.data[months[i]].id}" value="${value}" /></td>`

        }else {
            color = 'style="background: #ff000040";'
            data += `<td><input type="text" placeholder="" ${color} tabIndex=${index} class="form-control" data-lrn="${lrn}" data-schoolyearid="${schoolyear}" data-schooldaysid="${months[i]}" value="" /></td>`
        }
        
        index += totalStudents
    }

    return data
}

window.addEventListener("load", (e)=>{

})