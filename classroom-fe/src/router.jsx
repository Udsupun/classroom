import { createBrowserRouter } from "react-router-dom";
import Login from './views/Login.jsx';
import DefaultLayout from "./components/DefaultLayout.jsx";
import GuestLayout from "./components/GuestLayout.jsx";
import Students from "./views/Student.jsx";

const router = createBrowserRouter ([
  {
    path: '/',
    element: <DefaultLayout />,
    children: [
      {
        path: '/students',
        element: <Students />
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