import { useEffect, useState } from "react";
import { Navigate, Outlet } from "react-router-dom";
import axiosClient from "../axiosClient.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import { Link } from "react-router-dom";

export default function StudentProfile() {
  const [data, setDetails] = useState([]);
  const [loading, setLoading] = useState(true);
  const { user } = useStateContext();

  if (user.role === 'teacher') {
    return <Navigate to="/students" />
  }

  useEffect(()=> {
    getStudentDetails();
  }, [])

  const getStudentDetails = () => {
    setLoading(true)
    axiosClient.get('/student-details')
      .then(({ data }) => {
        console.log("!!!!@@@@");
        setLoading(false);
        setDetails(data.data);
        console.log("RESPONSE DATA");
        console.log(data);
        console.log(loading);
      })
      .catch((e) => {
        console.log(e);
        console.log("SET LOADING AND CATCH");
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
          <th>Score</th>
          <th>Submitted Date</th>
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
            </tr>
          ))}
          </tbody>
        }
      </table>
    </div>
  </div>
)

}