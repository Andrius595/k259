"use client";
import React, { useEffect } from "react";
import Button from "@mui/material/Button";
import { Avatar } from "@mui/material";
import SearchAppBar from "../navigation/appBar";
import "./profile.css";
import TextField from "@mui/material/TextField";

export default function efitProfileScreen() {
  return (
    <div>
      <SearchAppBar />
      <div className="profile">
        <div className="profile__info">
          <div className="row">
            <div className="column">
              <Avatar
                className="profile__avatar"
                alt="Remy Sharp"
                src="/static/images/avatar/1.jpg"
              />
              <h1>John Doe</h1>
            </div>
            <div className="column">
              <Button
                variant="contained"
                className="profile__edit_avatar_button"
              >
                Upload new Avatar
              </Button>
            </div>
          </div>

          <div className="form_container">
            <TextField
              id="outlined-basic"
              label="First Name"
              variant="outlined"
              className="profile__edit_form_input"
            />

            <TextField
              id="outlined-basic"
              label="Last Name"
              variant="outlined"
              className="profile__edit_form_input"
            />

            <TextField
              id="outlined-basic"
              label="Email"
              variant="outlined"
              className="profile__edit_form_input"
            />

            <TextField
              id="outlined-basic"
              label="Phone Number"
              variant="outlined"
              className="profile__edit_form_input"
            />

            <TextField
              id="outlined-basic"
              label="Password"
              variant="outlined"
              className="profile__edit_form_input"
            />

            <TextField
              id="outlined-basic"
              label="Confirm Password"
              variant="outlined"
              className="profile__edit_form_input"
            />

            <Button variant="contained" className="profile__edit_form_button">
              Save
            </Button>
          </div>
        </div>
      </div>
    </div>
  );
}
