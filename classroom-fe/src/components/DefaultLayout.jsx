import { useEffect } from "react";
import { Navigate, Outlet } from "react-router-dom";
import axiosClient from "../axiosClient.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";

export default function DefaultLayout() {
  const { user, token, setUser, setToken } = useStateContext();
  if (!token) {
    return <Navigate to="/login" />
  }

  const onLogout =  (ev) =>{
    ev.preventDefault();
    axiosClient.post('/logout')
    .then(({}) => {
       setUser(null)
       setToken(null)
    })
  }

  useEffect(() => {
    axiosClient.get('/user')
      .then(({data}) => {
         setUser(data)
      })
  }, [])

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