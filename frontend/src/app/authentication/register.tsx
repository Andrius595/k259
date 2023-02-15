import React, { useEffect } from "react";
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
        Sign up <i>now</i> to get started.
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
          <div className="group">
            <div className="form-row">
              <label htmlFor="firstName">First name</label>
              <input
                type="text"
                id="firstName"
                name="userFirstName"
                required
                pattern="^[^\d]+$"
                placeholder="ex: Odin"
              />
            </div>
            <div className="form-row">
              <label htmlFor="lastName">Last name</label>
              <input
                type="text"
                id="lastName"
                name="userLastName"
                required
                pattern="^[^\d]+$"
                placeholder="ex: Borson"
              />
            </div>
          </div>
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
            <div className="form-row">
              <label htmlFor="phoneNumber">Phone Number</label>
              <input
                type="tel"
                id="phoneNumber"
                name="userPhoneNumber"
                pattern="^\(?([0-9]{3})\)?[-.●]?([0-9]{3})[-.●]?([0-9]{4})$"
                placeholder="ex: 202-555-0125"
              />
            </div>
          </div>
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
        <div className="createAccount">
          <button className="button" type="submit">
            <span>Create Account</span>
          </button>
          <div className="logIn">
            Already have an account? <span>Log in</span>
          </div>
        </div>
      </form>
    </div>
  );
}

function SignUpForm(): JSX.Element {
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

export default SignUpForm;
