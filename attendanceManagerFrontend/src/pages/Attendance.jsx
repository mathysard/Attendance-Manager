import React, {useState, useEffect} from 'react'
import axios from 'axios'

function Attendance() {
  if(localStorage.getItem('isAdmin') === null) {
    window.location.assign('/');
  }

  const students = [];
  const date = new Date().getFullYear() + "-" + new Date().getMonth() + 1 + "-" + new Date().getDate();
  const fetchStudents = async () => {
    await axios.get('http://localhost:8000/getStudents')
    .then(data => {
      students.push(JSON.parse(data.data.students));
      // document.body.setAttribute("data-students", data.data.students);
    })
    // console.log(document.body.getAttribute("data-students"));
    console.log(students[0]);
  }

  fetchStudents();

  console.log(students)

  return (
    <>
      <h1 className="text-xl font-semibold">Présences du {date}</h1>
      {/* {
        students[0].map(student => (
          <p>{student.firstName} {student.lastName} : {student.classroom.id}/{student.classroom.name}</p>
        ))
      } */}
    </>
  )
}

export default Attendance