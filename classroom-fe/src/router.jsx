import { createBrowserRouter } from "react-router-dom";
import Login from './views/Login.jsx';
import DefaultLayout from "./components/DefaultLayout.jsx";
import GuestLayout from "./components/GuestLayout.jsx";
import Dashboard from "./views/Dashboard.jsx";
import Classroom from "./views/Classroom.jsx";
import Activities from "./views/Activities.jsx";

const router = createBrowserRouter ([
  {
    path: '/',
    element: <DefaultLayout />,
    children: [
      {
        path: '/dashboard',
        element: <Dashboard />
      },
      {
        path: '/classroom/:classroom_id',
        element: <Classroom />
      },
      {
        path: '/student/:student_id',
        element: <Activities />
      }
    ]
  },
  {
    path: '/',
    element: <GuestLayout />,
    children: [
      {
        path: '/login',
        element: <Login />
      },
    ]
  }
]);

export default router;