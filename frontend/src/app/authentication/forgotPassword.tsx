import React from "react";
import Logo from "./logo";
import "./authentication.css";

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
        Forgot your password?
      </p>
    </div>
  );
}

function Form(): JSX.Element {
  return (
    <div className="containerInputs">
      <form>
        <div className="userInputs">
          <p className="slogan">Enter your accounts email address</p>

          <div className="group">
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
          </div>
        </div>
        <div className="sendResetEmail">
          <button className="button" type="submit">
            <span>Send reset email</span>
          </button>
          <div className="backToLogIn">
            Back to <span>Log in</span> window
          </div>
        </div>
      </form>
    </div>
  );
}

function ForgotPasswordForm(): JSX.Element {
  return (
    <div className="container">
      <Logo />
      <div className="main">
        <Header text="Forgot your password?" />
        <Form />
      </div>
    </div>
  );
}

export default ForgotPasswordForm;
