import Image from "next/image";
import { Inter } from "@next/font/google";
import styles from "./page.module.css";
import SignUpForm from "./authentication/register";
import LogInForm from "./authentication/logIn";
import ForgotPasswordForm from "./authentication/forgotPassword";
import ResetPasswordForm from "./authentication/resetPassword";

const inter = Inter({ subsets: ["latin"] });

export default function Home() {
  return <SignUpForm />;
}
