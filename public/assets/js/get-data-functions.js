// DATA GETTER FUNCTIONS
// Get all students
async function  getStudentMasterlist() {

    let data = await fetch(`${baseUrl}studentdata/list.json`)
     .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
     })
 
     return data
 }
// Get all students base on the given lrn
async function getStudentListByLrn(lrns) {

    let data = await fetch(`${baseUrl}studentdata/listByLRN.json`,{
        method: 'POST',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            lrns: lrns
        })
    })
    .then((response)=>response.json())
    .then((data)=>{
        return data
    })
    .catch((error)=>{
        console.log(error)
    })

    return data
}
 // Level Master List
 async function  getLevelMasterList() {
 
     let data = await fetch(`${baseUrl}leveldata/list.json`)
      .then((response)=>response.json())
      .then((data)=>{
          return data
      })
      .catch((error)=>{
          console.log(error)
      })
  
      return data
 }
 //  Section Master List
 async function  getSectionMasterList() {
 
     let data = await fetch(`${baseUrl}sectiondata/list.json`)
      .then((response)=>response.json())
      .then((data)=>{
          return data
      })
      .catch((error)=>{
          console.log(error)
      })
  
      return data
 }
 //  Schoolyear Master List
 async function  getSchoolyearMasterList() {
 
     let data = await fetch(`${baseUrl}schoolyeardata/list.json`)
      .then((response)=>response.json())
      .then((data)=>{
          return data
      })
      .catch((error)=>{
          console.log(error)
      })
  
      return data
 }
 // Class Master List
 async function  getClassMasterList() {
 
     let data = await fetch(`${baseUrl}classdata/list.json`)
      .then((response)=>response.json())
      .then((data)=>{
          return data
      })
      .catch((error)=>{
          console.log(error)
      })
  
      return data
 }
 // Class Students Of the School Year
 async function getSchoolyearClassStudentList(class_id, schoolyear_id) {
     let data = await fetch(`${baseUrl}classstudentdata/list.json?classid=${class_id}&schoolyearid=${schoolyear_id}`)
      .then((response)=>response.json())
      .then((data)=>{
         return data
      })
      .catch((error)=>{
          console.log(error)
      })
  
      return data
 }
//  GET Curriculum Master List
async function getCurriculumMasterlist() {

    let data = await fetch(`${baseUrl}curriculumdata/list.json`)
     .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
     })
 
     return data
}

async function getStrandMasterlist() {

    let data = await fetch(`${baseUrl}stranddata/list.json`)
     .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
     })
 
     return data
}

async function getSemesterMasterlist() {

    let data = await fetch(`${baseUrl}semesterdata/list.json`)
     .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
     })
 
     return data
}

async function getPeriodMasterlist() {

    let data = await fetch(`${baseUrl}perioddata/list.json`)
     .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
     })
 
     return data
}

async function getSubjectMasterList() {

    let data = await fetch(`${baseUrl}subjectdata/list.json`)
     .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
     })
 
     return data
}

async function getCurriculumSubjects(curriculum_id, strand_id) {
    let data = await fetch(`${baseUrl}curriculumsubjectsdata/list.json?curriculumid=${curriculum_id}&strandid=${strand_id}`)
    .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
         return []
     })
 
     return data
}

async function getCurriculumSemesters(curriculum_id, strand_id)
{
    let data = await fetch(`${baseUrl}curriculumsubjectsdata/curriculumsemester.json?curriculumid=${curriculum_id}&strandid=${strand_id}`)
    .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
         return []
     })
 
     return data
}

async function getClassGrades(schoolyear_id, class_id) {
    let data = await fetch(`${baseUrl}subjectgradesdata/classgrades.json?schoolyearid=${schoolyear_id}&classid=${class_id}`)
    .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
         return []
     })
 
     return data
}

async function getStudentSubjectGrade(lrn, schoolyear_id, semester_id, period_id, subject_id)
{
    let data = await fetch(`${baseUrl}subjectgradesdata/studentgrade.json?lrn=${lrn}&schoolyearid=${schoolyear_id}&semesterid=${semester_id}&periodid=${period_id}&subjectid=${subject_id}`)
    .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
         return []
     })
 
     return data
}

async function getStudentSubjectsGrade(lrn, schoolyear_id, semester_id, period_id, subject_ids)
{
    let data = await fetch(`${baseUrl}subjectgradesdata/studentgrades.json`,{
        method: 'POST',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            lrn: lrn,
            schoolyearid: schoolyear_id,
            semesterid: semester_id,
            periodid:period_id,
            subjectids: subject_ids
        })
    })
    .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
         return []
     })
 
     return data
}

async function getStudentTraitsGrade(lrn, schoolyear_id, semester_id, period_id, trait_ids)
{
    let data = await fetch(`${baseUrl}traitgradesdata/studentgrades.json`,{
        method: 'POST',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            lrn: lrn,
            schoolyearid: schoolyear_id,
            semesterid: semester_id,
            periodid:period_id,
            traitids: trait_ids
        })
    })
    .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
         return []
     })
 
     return data
}

async function getReportCardTemplates()
{
    let data = await fetch(`${baseUrl}reportcardtemplatedata/list.json`,{
        method: 'GET'
    })
    .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
         return []
     })
 
     return data
}

async function getReportCardConfiguration(curriculumid, strandid)
{
    
    let data = await fetch(`${baseUrl}reportcardtemplatedata/configuration.json?curriculumid=${curriculumid}&strandid=${strandid}`,{
        method: 'GET'
    })
    .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
         return []
     })
 
     return data

}

async function getTeachersMasterList()
{
    let data = await fetch(`${baseUrl}teacherdata/list.json`)
    .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
         return []
     })
 
     return data
}

async function getTraitMasterList()
{
    let data = await fetch(`${baseUrl}traitdata/list.json`)
    .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
         return []
     })
 
     return data
}

async function getCurriculumTraits(curriculum_id, strand_id)
{
    let data = await fetch(`${baseUrl}curriculumtraitsdata/list.json?curriculumid=${curriculum_id}&strandid=${strand_id}`)
    .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
         return []
     })
 
     return data
}

async function getSchoolyearSchoolDays(id)
{
    let data = await fetch(`${baseUrl}schooldaysdata/list.json?id=${id}`)
    .then((response)=>response.json())
     .then((data)=>{
         return data
     })
     .catch((error)=>{
         console.log(error)
         return []
     })
 
     return data
}

async function getMonthlyAttendance(lrn, schoolyearid, schooldayids)
{
    let data = await fetch(`${baseUrl}attendancedata/monthlyattendance.json`,{
        method: "POST",
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            lrn:lrn,
            schoolyear_id: schoolyearid,
            schoolday_ids: schooldayids
        })
    })
    .then((response) => response.json())
    .then((data) => {
        return data
    })
    .catch((error) => {
        console.log(error)
    })

    return data
}