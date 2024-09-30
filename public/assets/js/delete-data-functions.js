// DATA DELETION FUNCTIONS
async function removeStudentFromClass(lrn, class_id, schoolyear)
{
    let data = await fetch(`${baseUrl}classstudentdata/remove.json?classid=${class_id}&schoolyearid=${schoolyear}&lrn=${lrn}`, {
        method: "DELETE",
        headers : {
            "Content-Type" : "application/json"
        },
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

async function deleteClass(classid)
{
    let data = await fetch(`${baseUrl}classdata/delete.json?classid=${classid}`,{
        method:"DELETE",
        headers: {
            "Content-Type" : "application/json"
        }
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

async function deleteLevel(levelid)
{
    let data = await fetch(`${baseUrl}leveldata/delete.json?levelid=${levelid}`,{
        method: 'DELETE',
        headers: {
            "Content-Type":"application/json"
        }
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

async function deleteSection(sectionid)
{
    let data = await fetch(`${baseUrl}sectiondata/delete.json?sectionid=${sectionid}`,{
        method: 'DELETE',
        headers: {
            "Content-Type":"application/json"
        }
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

async function deleteSchoolyear(schoolyearid)
{
    let data = await fetch(`${baseUrl}schoolyeardata/delete.json?schoolyearid=${schoolyearid}`,{
        method: 'DELETE',
        headers: {
            "Content-Type":"application/json"
        }
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

async function deleteLevel(levelid)
{
    let data = await fetch(`${baseUrl}leveldata/delete.json?levelid=${levelid}`,{
        method: 'DELETE',
        headers: {
            "Content-Type":"application/json"
        }
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

async function deleteCurriculum(curriculumid)
{
    let data = await fetch(`${baseUrl}curriculumdata/delete.json?curriculumid=${curriculumid}`,{
        method: 'DELETE',
        headers: {
            "Content-Type":"application/json"
        }
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

async function deleteStrand(strandid)
{
    let data = await fetch(`${baseUrl}stranddata/delete.json?strandid=${strandid}`,{
        method: 'DELETE',
        headers: {
            "Content-Type":"application/json"
        }
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

async function deleteSemester(semesterid)
{
    let data = await fetch(`${baseUrl}semesterdata/delete.json?semesterid=${semesterid}`,{
        method: 'DELETE',
        headers: {
            "Content-Type":"application/json"
        }
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

async function deletePeriod(periodid)
{
    let data = await fetch(`${baseUrl}perioddata/delete.json?periodid=${periodid}`,{
        method: 'DELETE',
        headers: {
            "Content-Type":"application/json"
        }
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

async function deleteSubject(subjectid)
{
    let data = await fetch(`${baseUrl}subjectdata/delete.json?subjectid=${subjectid}`,{
        method: 'DELETE',
        headers: {
            "Content-Type":"application/json"
        }
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

async function removeSubjectFromCurriculum(curriculumid, strandid, semesterid, subjectid)
{

    let data = await fetch(`${baseUrl}curriculumsubjectsdata/remove.json?curriculumid=${curriculumid}&strandid=${strandid}&semesterid=${semesterid}&subjectid=${subjectid}`, {
        method: 'DELETE',
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then((response) => {
        console.log(response)
        return response.json()
    })
    .then((data) => {
        console.log(data)
        return data
    })
    .catch((error) => {
        console.log(error)
    })

    return data

}

async function deleteReportCardTemplate(id) {
    let data = await fetch(`${baseUrl}reportcardtemplatedata/delete.json?id=${id}`,{
        method: 'DELETE'
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

async function deleteTeacher(id) {
    let data = await fetch(`${baseUrl}teacherdata/delete.json?id=${id}`, {
        method: 'DELETE'
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

async function deleteTrait(id)
{
    let data = await fetch(`${baseUrl}traitdata/delete.json?id=${id}`,{
        method: 'DELETE',
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

async function removeTraitFromCurriculum(id) {

    let data = await fetch(`${baseUrl}curriculumtraitsdata/delete.json?id=${id}`,{
        method: 'DELETE',
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

async function deleteSchooldayRecord(id)
{
    let data = await fetch(`${baseUrl}schooldaysdata/delete.json?id=${id}`,{
        method: 'DELETE'
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