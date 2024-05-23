import { useRef } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../axiosClient";

export default function login() {

  const emailRef = useRef();
  const passwordRef = useRef();

  const submit = (e) => {
    const payload = {
      email: emailRef.current.value,
      password: passwordRef.current.value,
    };
    console.log("LOGIN FUNCTION");
    e.preventDefault();
    axiosClient.post("/login", payload).then(({data}) => {
      setUser(data.user);
      setToken(data.token);
    }).catch(err => {
      const response = err.response;
      if (response && response.status === 422) {
        console.log(response.data.errors);
      }
    })
  }
  return(
    <div className="login-signup-form animated fadeinDown">
      <div className="form">
        <h1 className="title">
          Login To Your Account
        </h1>
        <form onSubmit={submit}>
          <input ref={emailRef} type="email" placeholder="Email" />
          <input ref={passwordRef} type="password" placeholder="Password" />
          <button className="btn btn-block">Login</button>
          <p className="message">
            Not Registered? <Link to='/register'>Register</Link>
          </p>
        </form>
      </div>
    </div>
  )
}