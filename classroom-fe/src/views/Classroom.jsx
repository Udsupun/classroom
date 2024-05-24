import { useEffect, useState } from "react";
import { useParams, Navigate, Outlet } from "react-router-dom";
import axiosClient from "../axiosClient.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import { Link } from "react-router-dom";

export default function Classroom() {
  const { classroom_id } = useParams();
  const [data, setDetails] = useState([]);
  const [loading, setLoading] = useState(true);
  const { user } = useStateContext();

  console.log("PARAM");
  console.log(classroom_id);

  // if (user.role != 'teacher') {
  //   return <Navigate to="/my-profile" />
  // }
  console.log(user.role);

  useEffect(()=> {
    getStudents();
  }, [])

  const getStudents = () => {
    setLoading(true)
    axiosClient.get(`/grade-students/${classroom_id}`)
      .then(({ data }) => {
        setLoading(true);
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
      <h1>Users</h1>
      <Link className="btn-add" to="/users/new">Add new</Link>
    </div>
    <div className="card animated fadeInDown">
      <table>
        <thead>
        <tr>
          <th>Activity</th>
          <th>Score</th>
          <th>Submitted Date</th>
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
          {data.activities.map(activity => (
            <tr key={activity.activity_id}>
              <td>{activity.name}</td>
              <td>{activity.score}</td>
              <td>{activity.submitted_at}</td>
              <td>
                <Link className="btn-edit" to={'/users/' + activity.activity_id}>Edit</Link>
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