import { useEffect, useState } from "react";
import axiosClient from "../axiosClient.js";
import Table from "../components/Table.jsx";
import StudentProfile from "../components/StudentProfile.jsx";
import TitleSection from "../components/TitleSection.jsx";

export default function StudentDashboard() {
  const [data, setDetails] = useState([]);
  const [loading, setLoading] = useState(true);

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
      {
        !loading &&
        <div>
          <StudentProfile
            loading={loading}
            name={data.details.name}
            grade={data.grade.name}
            address={data.details.address}
          />
          <TitleSection title="My Activities" />
          <Table
            headers={["Activity", "Subject", "Score"]}
            data={data.activities.map((activity) => [activity.name, activity.subject, activity.score])}
            loading={loading}
          />
        </div>
      }
    </div>
  )
}