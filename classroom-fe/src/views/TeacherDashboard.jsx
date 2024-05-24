import { useEffect, useState } from "react";
import { Navigate, Outlet } from "react-router-dom";
import axiosClient from "../axiosClient.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import { Link } from "react-router-dom";

export default function TeacherDashboard() {
  const [data, setDetails] = useState([]);
  const [loading, setLoading] = useState(true);
  const { user } = useStateContext();

  if (user.role === 'student') {
    return <Navigate to="/my-activities" />
  }

  useEffect(()=> {
    getClassDetails();
  }, [])

  const getClassDetails = () => {
    setLoading(true)
    axiosClient.get('/teacher-classes')
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
        <h2>My Classes</h2>
      </div>
      <div className="card animated fadeInDown">
        <table>
          <thead>
          <tr>
            <th>Class Name</th>
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
            {data.map(class_room => (
              <tr key={class_room.uuid}>
                <td>{class_room.name}</td>
                <td>
                  <Link className="btn-edit" to={'/classroom/' + class_room.uuid}>Go to Class</Link>
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