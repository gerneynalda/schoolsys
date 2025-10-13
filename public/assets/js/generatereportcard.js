let btn_ShowStudents = document.querySelector("#showStudents")

btn_ShowStudents.addEventListener("click", async (e)=>{
    let dropdown_Schoolyear = document.querySelector("#schoolyear")
    let dropdown_Class = document.querySelector("#class")
    let dropdown_Curriculum = document.querySelector("#curriculum")
    let dropdown_Strand = document.querySelector("#strand")
    let loader = document.querySelector("#loader")

    let schoolyear_id = dropdown_Schoolyear.value
    let class_id = dropdown_Class.value
    let curriculum_id = dropdown_Curriculum.value
    let strand_id = dropdown_Strand.value
    let table_student_list = document.querySelector("#table-students")

    if(dropdown_Schoolyear.value == "") {
        addNotificationToQeue("alert-danger", "Please select a school year.")
        return false
    }

    if(dropdown_Class.value == "") {
        addNotificationToQeue("alert-danger", "Please select a class.")
        return false
    }

    if(dropdown_Curriculum.value == "") {
        addNotificationToQeue("alert-danger", "Please select a curriculum.")
        return false
    }

    if(dropdown_Strand.value == "") {
        addNotificationToQeue("alert-danger", "Please select a strand.")
        return false
    }

    // loader show
    loader.setAttribute("style", "display:flex;")

    // clear the tabel first
    table_student_list.innerHTML = ""

    // query for a list of students 
    let result = await getSchoolyearClassStudentList(class_id,schoolyear_id)    

    if(Object.keys(result.data).length <= 0) {
        // loader hide
        loader.setAttribute("style", "display:none;")

        // show no records of student in this class message
        let msg = `<tbody>
            <tr>
                </td>
                    <div class="alert alert-info" style="margin-bottom:0; text-align:center;"><strong>There are no students in this class.</strong></div>
                </td>
            </tr>
        </tbody>`
        table_student_list.innerHTML = msg

        addNotificationToQeue("alert-info", "No record of students found.")
        return false
    }

    console.log(result.data)

    // lrns contains the lrns of the students in a class in a given schoolyear
    // the output of the query getSchoolyearClassStudentList
    let lrns = []
    for(let i in result.data) {
        lrns.push(result.data[i].lrn)
    }

    // get the details of each student using their lrn
    // the query getSchoolyearClasStudentList only returns the lrn of the students in a class it does not include the details
    result = await getStudentListByLrn(lrns)

    console.log(result)

    // display in a table the details
    let table_content = ''
    table_content += `<thead>
        <tr>
            <th>
                <input type="checkbox" id="select-all" />
            </th>
            <th>Name</th>
            <th></th>
        </tr>
    </thead>`
    table_content += '<tbody>'
    for(let i in result.data) {
        table_content += `<tr>
            <td><input type="checkbox" value="${result.data[i].lrn}" /></td>
            <td>${result.data[i].lastname}, ${result.data[i].firstname} ${result.data[i].middlename} ${result.data[i].suffix}</td>
            <td></td>
        </tr>`
    }
    table_content += '</tbody>'

    table_student_list.innerHTML = table_content
    loader.setAttribute("style", "display:none;")
})


let table_student_list = document.querySelector("#table-students")
const lrns = []

table_student_list.addEventListener("click", async (e) => {

    if(e.target.type == 'checkbox' && e.target.id == "") { 
        lrns.push(e.target.value)
    }
    
    if(e.target.id == "select-all") {
        
        let inputs
        switch(e.target.checked) {
            case true:

                inputs = table_student_list.querySelectorAll('input[type="checkbox"]')
                for(let i in inputs) {
                    if(inputs[i].id == "") {
                        inputs[i].checked =  true
                        lrns.push(inputs[i].value)
                    }
                }
                break;

            case false:

                inputs = table_student_list.querySelectorAll('input[type="checkbox"]')
                for(let i in inputs) {
                    if(inputs[i].id == "") {
                        inputs[i].checked = false
                        lrns.splice(lrns.indexOf(inputs[i].value), 1)
                    }
                }
                break;

            default:
                throw new Error("ERROR: Input accepts boolean value given"+typeof(e.target.checked))
        }

    }

})

let btn_generateReportCard = document.querySelector("#generate_report_card")

btn_generateReportCard.addEventListener("click", async (e) => {
    
    let dropdown_schoolyear = document.querySelector("#schoolyear")
    let dropdown_class = document.querySelector("#class")
    let dropdown_curriculum = document.querySelector("#curriculum")
    let dropdown_strand = document.querySelector("#strand")
    let loader = document.querySelector("#loader")

    // show loader
    loader.setAttribute("style","display:flex;")

    if(lrns.length <= 0) {
        addNotificationToQeue("alert-warning", "Please select student(s)")
        loader.setAttribute("style","display:none;")
        return false
    }
    let result = await generateReportCard(dropdown_schoolyear.value, dropdown_class.value, dropdown_curriculum.value, dropdown_strand.value, lrns)

    if(result.success) {
        loader.setAttribute("style","display:none;")
        let confirmed = confirm("Download generated report card?")
        if(confirmed) {
            window.location.href = result.data[0]
        }

    } else  {
        loader.setAttribute("style","display:none;")
        addNotificationToQeue("alert-warning", result.message)
    }

})