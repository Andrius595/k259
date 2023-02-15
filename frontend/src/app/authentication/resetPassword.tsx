import React from "react";
import Logo from "./logo";
import Header from "./header";
import "./authentication.css";

function Form(): JSX.Element {
  return (
    <div className="containerInputs">
      <form>
        <div className="userInputs">
          <p className="slogan">Enter your new password!</p>
          <div className="group">
            <div className="form-row">
              <label htmlFor="password">Password</label>
              <input
                className="error"
                type="text"
                id="password"
                name="userPassword"
                title="Must contain at least one uppercase letter, one lowercase letter, and be between 8 and 32 characters long."
                required
                pattern="(?=^.{8,32}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                placeholder="Contains uppercase, lowercase, 8-32ch"
              />
            </div>
            <div className="form-row">
              <label htmlFor="passwordConfirm">Confirm Password</label>
              <input
                className="error"
                type="text"
                id="passwordConfirm"
                name="userPasswordConfirm"
                title="Must contain at least one uppercase letter, one lowercase letter, and be between 8 and 32 characters long."
                required
                pattern="(?=^.{8,32}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                placeholder="Match the password"
              />
            </div>
          </div>
        </div>
        <div className="resetPass">
          <button className="button" type="submit">
            <span>Reset password</span>
          </button>
          <div className="backToLogIn">
            Back to <span>Log in</span> window
          </div>
        </div>
      </form>
    </div>
  );
}

function ResetPasswordForm(): JSX.Element {
  return (
    <div className="container">
      <Logo />
      <div className="main">
        <Header text="Reset password." />
        <Form />
      </div>
    </div>
  );
}

export default ResetPasswordForm;
