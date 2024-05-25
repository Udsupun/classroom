import { useEffect, useState } from "react";
import { Navigate, Outlet } from "react-router-dom";
import axiosClient from "../axiosClient.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import { Link } from "react-router-dom";
import '../css/teacher-dashboard.css';
import TitleSection from "../components/TitleSection.jsx";
import NoContent from "../components/NoContent.jsx";

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
    <div className="dashboard-container">
      {!loading &&
        <TitleSection title="My Classes" />
      }
      <div className="dashboard-card">
        {loading ?? <div className="loading">Loading...</div>}
        {
        !loading && (
          (data && data.length > 0) ?
            <div className="classes-grid">
              {data.map(class_room => (
                <div key={class_room.uuid} className="class-card">
                  <div className="class-details">
                    <div><strong>Name:</strong> {class_room.name}</div>
                  </div>
                  <div className="class-actions">
                    <Link className="btn-edit" to={`/classroom/${class_room.uuid}`}>Go to Class</Link>
                  </div>
                </div>
              ))}
            </div>
          : <NoContent message="No Classrooms available" />
        )}
      </div>
    </div>
  )
}