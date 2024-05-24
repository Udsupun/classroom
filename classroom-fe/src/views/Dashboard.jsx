import { useStateContext } from "../contexts/ContextProvider.jsx";
import StudentDashboard from "./StudentDashboard.jsx";
import TeacherDashboard from "./TeacherDashboard.jsx";

export default function Dashboard() {
  const { user } = useStateContext();

  if (user.role === 'student') {
    return <StudentDashboard />;
  } else if (user.role === 'teacher') {
    return <TeacherDashboard />;
  }
}
