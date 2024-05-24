import { useEffect, useState } from "react";
import { useParams, Navigate, Outlet } from "react-router-dom";
import axiosClient from "../axiosClient.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import { Link } from "react-router-dom";

export default function Classroom() {
  const { classroom_id } = useParams();
  const [data, setDetails] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(()=> {
    getStudents();
  }, [])

  const getStudents = () => {
    setLoading(true)
    axiosClient.get(`/grade-students/${classroom_id}`)
      .then(({ data }) => {
        setLoading(false);
        setDetails(data.data);
      })
      .catch((e) => {
        console.log(e);
        setLoading(false)
      })
  }

  return(
    <div>
    <div style={{display: 'flex', justifyContent: "space-between", alignItems: "center"}}>
      {!loading &&
        <h1>{data.grade.name} Students</h1>
      }
    </div>
    <div className="card animated fadeInDown">
      <table>
        <thead>
        <tr>
          <th>Name</th>
          <th>email</th>
          <th>Address</th>
          <th>Actions</th>
        </tr>
        </thead>
        {loading &&
          <tbody>
          <tr>
            <td colSpan="5" className="text-center">
              Loading...
            </td>
          </tr>
          </tbody>
        }
        {!loading &&
          <tbody>
          {data.students.map(student => (
            <tr key={student.uuid}>
              <td>{student.details.name}</td>
              <td>{student.details.email}</td>
              <td>{student.details.address}</td>
              <td>
                <Link className="btn-edit" to={'/student/' + student.uuid}>Go to Student</Link>
              </td>
            </tr>
          ))}
          </tbody>
        }
      </table>
    </div>
  </div>
)

}