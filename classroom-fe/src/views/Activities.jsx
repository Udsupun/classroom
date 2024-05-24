import { useEffect, useState } from "react";
import { useParams, Navigate, Outlet } from "react-router-dom";
import axiosClient from "../axiosClient.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import { Link } from "react-router-dom";

export default function Activities() {
  const { student_id } = useParams();
  const [data, setDetails] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(()=> {
    getStudentsActivities();
  }, [])

  const getStudentsActivities = () => {
    setLoading(true)
    axiosClient.get(`/student-activities/${student_id}`)
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
              <h3> Name: {data.details.name} </h3>
              <h3> Grade: {data.grade.name} </h3>
              <h3> Address: {data.details.address} </h3>
            </div>
          }
      </div>
      <div style={{display: 'flex', justifyContent: "space-between", alignItems: "center"}}>
        <h2>Activities</h2>
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
              <tr key={activity.uuid}>
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