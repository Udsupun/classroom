import { useEffect, useState } from "react";
import { Navigate, Outlet } from "react-router-dom";
import axiosClient from "../axiosClient.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import { Link } from "react-router-dom";

export default function StudentProfile() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(false);
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
        setLoading(false)
        setUsers(data.data)
      })
      .catch(() => {
        setLoading(false)
      })
  }

  return(
    <div id="defaultLayout">
      <div className="content">
        <header>
          <div>
            Header
          </div>
          <div>
            {user.first_name}
            <a href="#" onClick={onLogout} className="btn-logout">Logout</a>
          </div>
        </header>
        <main>
          <Outlet />
        </main>
      </div>
    </div>
  )
}