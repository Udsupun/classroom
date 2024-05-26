import { useEffect } from "react";
import { Navigate, Outlet } from "react-router-dom";
import axiosClient from "../axiosClient.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";

export default function DefaultLayout() {
  const { user, token, setUser, setToken } = useStateContext();

  if (!token) {
    return <Navigate to="/login" />
  }

  const onLogout = (ev) => {
    ev.preventDefault();
    axiosClient.post('/logout')
      .then(() => {
        setUser(null);
        setToken(null);
      })
      .catch(error => {
        console.error('Logout error:', error);
      });
  };

  useEffect(() => {
    axiosClient.get('/user')
      .then(({ data }) => {
        setUser(data);
      })
      .catch(error => {
        console.error('Fetch user error:', error);
      });
  }, []);

  return (
    <div id="defaultLayout">
      <div className="content">
        <header>
          <img className="header-logo" src="/logo.png" alt="Logo" />
          <div className="header-user">
            <span className="user-name">{user && user.first_name}</span>
            <a href="#" onClick={onLogout} className="btn-logout">Logout</a>
          </div>
        </header>
        <main>
          <Outlet />
        </main>
      </div>
    </div>
  );
}
