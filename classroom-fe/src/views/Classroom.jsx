import { useEffect, useState } from "react";
import { useParams, Navigate, Outlet } from "react-router-dom";
import axiosClient from "../axiosClient.js";
import { Link } from "react-router-dom";
import Table from "../components/Table.jsx";
import TitleSection from "../components/TitleSection.jsx";

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
      {!loading &&
        <TitleSection title={`${data.grade.name} Students`} />
      }
      {
        !loading &&
        <Table
          headers={["Name", "Email", "Address", "Actions"]}
          data={
            data.students.map(
              (student) => [
                student.details.name,
                student.details.email,
                student.details.address,
                <Link className="btn-edit" to={'/student/' + student.uuid}>Activities</Link>
              ]
            )
          }
          loading={loading}
        />
      }
    </div>
  )
}