import { Link } from "react-router-dom";

export default function login() {
  const submit = (e) => {
    e.preventDefault();
  }
  return(
    <div className="login-signup-form animated fadeinDown">
      <div className="form">
        <h1 className="title">
          Login To Your Account
        </h1>
        <form onSubmit={submit}>
          <input type="email" placeholder="Email" />
          <input type="password" placeholder="Password" />
          <button className="btn btn-block">Login</button>
          <p className="message">
            Not Registered? <Link to='/register'>Register</Link>
          </p>
        </form>
      </div>
    </div>
  )
}