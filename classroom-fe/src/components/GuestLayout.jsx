import { Navigate, Outlet } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider.jsx";

export default function GuestLayout() {
  const { token } = useStateContext();
  if (token) {
    return <Navigate to="/" />
  }
  console.log("GUEST");
  console.log(token);
  return(
    <div>
      <div>
        <Outlet />
      </div>
    </div>
  )
}