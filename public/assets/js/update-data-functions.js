// UPDATE DATA FUNCTIONS
async function updateLevel(id, name)
{
    let data = await fetch(`${baseUrl}leveldata/edit.json`,{
        method: 'PUT',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({levelid:id, name:name})
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

async function updateSection(id, name)
{
    let data = await fetch(`${baseUrl}sectiondata/edit.json`,{
        method: 'PUT',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({sectionid:id,name:name})
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

async function updateSchoolyear(id, name)
{
    let data = await fetch(`${baseUrl}schoolyeardata/edit.json`,{
        method: 'PUT',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({schoolyearid:id, name:name})
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

async function updateCurriculum(id, name)
{
    let data = await fetch(`${baseUrl}curriculumdata/edit.json`,{
        method: 'PUT',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({curriculumid:id,name:name})
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

async function updateStrand(id, name)
{
    let data = await fetch(`${baseUrl}stranddata/edit.json`,{
        method: 'PUT',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({strandid:id,name:name})
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

async function updateSemester(id, name)
{
    let data = await fetch(`${baseUrl}semesterdata/edit.json`,{
        method: 'PUT',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({semesterid:id,name:name})
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

async function updatePeriod(id, name)
{
    let data = await fetch(`${baseUrl}perioddata/edit.json`,{
        method: 'PUT',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({periodid:id,name:name})
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

async function updateSubject(id, name, description)
{
    let data = await fetch(`${baseUrl}subjectdata/edit.json`,{
        method: 'PUT',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({subjectid:id,name:name, description:description})
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

async function updateTeacher(id, lastname, firstname, middlename, suffix)
{
    let data = await fetch(`${baseUrl}teacherdata/save.json`,{
        method:'PUT',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            id:id,
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

async function updateClassAdviser(classid, empuid)
{
    let data = await fetch(`${baseUrl}classdata/save.json`,{
        method:'PUT',
        headers: {
            "Content-Type":"application/json"
        },
        body:JSON.stringify({
            class_id:classid,
            empuid:empuid
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

async function updateTrait(id, description)
{
    let data = await fetch(`${baseUrl}traitdata/save.json`,{
        method: 'PUT',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            id:id,
            description:description
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

async function saveNoOfDays(id, value)
{
    let data = await fetch(`${baseUrl}schooldaysdata/edit.json`,{
        method: 'PUT',
        headers: {
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            id, id,
            no_of_days:value
        })
    })
    .then((response) =>  response.json())
    .then((data) => {
        return data
    })
    .catch((error) => {
        console.log(error)
    })

    return data
}