import { useEffect, useState } from "react";
import { Navigate, Outlet } from "react-router-dom";
import axiosClient from "../axiosClient.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";

export default function StudentDashboard() {
  const [data, setDetails] = useState([]);
  const [loading, setLoading] = useState(true);
  const { user } = useStateContext();

  if (user.role === 'teacher') {
    return <Navigate to="/my-classrooms" />
  }

  useEffect(()=> {
    getStudentDetails();
  }, [])

  const getStudentDetails = () => {
    setLoading(true)
    axiosClient.get('/dashboard-details')
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
        {loading &&
          <h3> Loading... </h3>
        }
        {!loading &&
          <div>
            <h3> Name: {data.first_name} {data.last_name} </h3>
            <h3> Grade: {data.grade} </h3>
            <h3> Address: {data.address} </h3>
          </div>
        }
    </div>
    <div style={{display: 'flex', justifyContent: "space-between", alignItems: "center"}}>
      <h2>My Activities</h2>
    </div>
    <div className="card animated fadeInDown">
      <table>
        <thead>
        <tr>
          <th>Activity</th>
          <th>Subject</th>
          <th>Score</th>
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
              <td>{activity.subject}</td>
              <td>{activity.score}</td>
            </tr>
          ))}
          </tbody>
        }
      </table>
    </div>
  </div>
)

}