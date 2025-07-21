// DATA CREATE FUNCTIONS
async function createNewClass(level, section, adviser)
{   

    let data = await fetch(`${baseUrl}classdata/create.json`, {
        method: "POST",
        headers: {
            "Content-Type" : "application/json"
        },
        body: JSON.stringify({
            level_id:level,
            section_id:section,
            adviser_id: adviser
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

async function addStudentsToClass(lrns, class_id, schoolyear)
{
    let data = await fetch(`${baseUrl}classstudentdata/add.json`, {
        method: "POST",
        headers : {
            "Content-Type" : "application/json"
        },
        body: JSON.stringify({lrn:lrns, class_id:class_id, schoolyear_id:schoolyear})
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

async function createLevel(name)
{
    let data = await fetch(`${baseUrl}leveldata/add.json`,{
        method: 'POST',
        headers: {
            "Content-Type" : "application/json"
        },
        body: JSON.stringify({name:name})
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

async function createSection(name)
{
    let data = await fetch(`${baseUrl}sectiondata/add.json`,{
        method: 'POST',
        headers: {
            "Content-Type" : "application/json"
        },
        body: JSON.stringify({name:name})
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

async function createSchoolyear(name)
{
    let data = await fetch(`${baseUrl}schoolyeardata/add.json`,{
        method: 'POST',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({name:name})
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

async function createCurriculum(name)
{
    let data = await fetch(`${baseUrl}curriculumdata/create.json`,{
        method: 'POST',
        headers: {
            "Content-Type" : "application/json"
        },
        body: JSON.stringify({name:name})
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

async function createStrand(name)
{
    let data = await fetch(`${baseUrl}stranddata/create.json`,{
        method: 'POST',
        headers: {
            "Content-Type" : "application/json"
        },
        body: JSON.stringify({name:name})
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

async function createSemester(name)
{
    let data = await fetch(`${baseUrl}semesterdata/create.json`,{
        method: 'POST',
        headers: {
            "Content-Type" : "application/json"
        },
        body: JSON.stringify({name:name})
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

async function createPeriod(name)
{
    let data = await fetch(`${baseUrl}perioddata/create.json`,{
        method: 'POST',
        headers: {
            "Content-Type" : "application/json"
        },
        body: JSON.stringify({name:name})
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

async function createSubject(name, description)
{
    let data = await fetch(`${baseUrl}subjectdata/create.json`,{
        method: 'POST',
        headers: {
            "Content-Type" : "application/json"
        },
        body: JSON.stringify({name:name, description:description})
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

async function addSubjectToCurriculum(subjects, curriculum_id, strand_id)
{
    let data = await fetch(`${baseUrl}curriculumsubjectsdata/add.json`,{
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({subjects:subjects, curriculumid:curriculum_id, strandid:strand_id})
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

async function saveSubjectGrade(lrn, schoolyearid, classid, curriculumid, strandid, semesterid, periodid, subjectid, grade)
{
    let data = await fetch(`${baseUrl}subjectgradesdata/add.json`,{
        method: 'POST',
        headers: {
            "Content-Type":"application/json"
        },
        body:JSON.stringify({
            lrn:lrn,
            schoolyearid: schoolyearid,
            classid: classid,
            curriculumid: curriculumid,
            strandid:strandid,
            semesterid: semesterid,
            periodid: periodid,
            subjectid: subjectid,
            grade: grade
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

async function saveTraitGrade(lrn, schoolyearid, classid, curriculumid, strandid, semesterid, periodid, traitid, grade)
{
    let data = await fetch(`${baseUrl}traitgradesdata/add.json`,{
        method: 'POST',
        headers: {
            "Content-Type":"application/json"
        },
        body:JSON.stringify({
            lrn:lrn,
            schoolyearid: schoolyearid,
            classid: classid,
            curriculumid: curriculumid,
            strandid:strandid,
            semesterid: semesterid,
            periodid: periodid,
            traitid: traitid,
            grade: grade
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

async function addReportCardTemplate(formData)
{   
    let data = await fetch(`${baseUrl}reportcardtemplatedata/add.json`,{
        method: 'POST',
        body:formData
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

async function saveReportCardConfiguration(reportcardtemplateid, curriculumid, strandid, config)
{
    let data = await fetch(`${baseUrl}reportcardtemplatedata/save.json`,{
        method: 'POST',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            reportcardtemplateid: reportcardtemplateid,
            curriculumid: curriculumid,
            strandid: strandid,
            configuration: config
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

async function generateReportCard(schoolyearid, classid, curriculumid, strandid, lrns)
{
    let data = await fetch(`${baseUrl}createreportcarddata/generatereportcard.json`,{
        method: 'POST',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            schoolyearid: schoolyearid,
            classid: classid,
            curriculumid: curriculumid,
            strandid: strandid,
            lrns:lrns
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

async function addTeacher(lastname, firstname, middlename, suffix)
{
    let data = await fetch(`${baseUrl}teacherdata/add.json`,{
        method: 'POST',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            lastname:lastname,
            firstname:firstname,
            middlename:middlename,
            suffix:suffix
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

async function saveTrait(description)
{
    let data = await fetch(`${baseUrl}traitdata/save.json`, {
        method: 'POST',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            description: description
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

async function addTraitToCurriculum(traits, curriculum_id, strand_id)
{
    let data = await fetch(`${baseUrl}curriculumtraitsdata/create.json`,{
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({traits:traits, curriculumid:curriculum_id, strandid:strand_id})
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

async function saveSchoolyearSchoolDays(schooldays)
{
    let data = await fetch(`${baseUrl}schooldaysdata/create.json`,{
        method: 'POST',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({schooldays,schooldays})
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

async function saveMonthlyAttendanceById(id, type, value)
{
    let data = await fetch(`${baseUrl}attendancedata/save.json`,{
        method: 'POST',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            id:id,
            type:type,
            value:value
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

async function saveMonthlyAttendance(lrn, schoolyear_id, schooldays_id, type, value)
{
    let data = await fetch(`${baseUrl}attendancedata/save.json`,{
        method: 'POST',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            lrn:lrn,
            schoolyear_id:schoolyear_id,
            schooldays_id:schooldays_id,
            type:type,
            value:value
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