import React from "react";
import Logo from "./logo";
import Header from "./header";
import "./authentication.css";

function Form(): JSX.Element {
  return (
    <div className="containerInputs">
      <form>
        <div className="userInputs">
          <p className="slogan">Let&apos;s do this!</p>

          <div className="logInInput">
            <div className="form-row">
              <label htmlFor="email">Email</label>
              <input
                type="email"
                id="email"
                name="userEmail"
                required
                placeholder="ex: odinborson@gmail.com"
              />
            </div>
            <div className="form-row">
              <label htmlFor="password">Password</label>
              <input
                className="error"
                type="text"
                id="password"
                name="userPassword"
                required
                pattern="(?=^.{8,32}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                placeholder="Your password"
              />
            </div>
          </div>
        </div>
        <div className="userLogIn">
          <button className="button" type="submit">
            <span>Log in</span>
          </button>
          <div className="resetPassword">
            Forgot your password? <span>Reset password</span>
          </div>
        </div>
      </form>
    </div>
  );
}

function LogInForm(): JSX.Element {
  return (
    <div className="container">
      <Logo />
      <div className="main">
        <Header text="Log in." />
        <Form />
      </div>
    </div>
  );
}

export default LogInForm;
