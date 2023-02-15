import React from "react";
import "./authentication.css";

function Logo(): JSX.Element {
  return (
    <div className="logo">
      <div className="imageText">
        <p className="logoText">Trash Tracker</p>
      </div>
    </div>
  );
}

function Header(): JSX.Element {
  return (
    <div className="headerInfo">
      <p className="notice">
        Welcome to TrashTracker
        <br />
        <br />
        The easiest way to report and organize clean-up events in your
        community!
        <br />
        <br />
        Log in.
      </p>
    </div>
  );
}

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
        <Header />
        <Form />
      </div>
    </div>
  );
}

export default LogInForm;
