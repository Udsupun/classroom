import { createBrowserRouter } from "react-router-dom";
import Login from './views/Login.jsx';
import DefaultLayout from "./components/DefaultLayout.jsx";
import GuestLayout from "./components/GuestLayout.jsx";
import StudentProfile from "./views/StudentProfile.jsx";
import StudentActivitesList from "./views/StudentActivitesList.jsx";
import StudentsList from "./views/StudentsList.jsx";

const router = createBrowserRouter ([
  {
    path: '/',
    element: <DefaultLayout />,
    children: [
      {
        path: '/my-profile',
        element: <StudentProfile />
      },
      {
        path: '/activities',
        element: <StudentActivitesList />
      },
      {
        path: '/students',
        element: <StudentsList />
      },
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