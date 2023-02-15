import Image from "next/image";
import { Inter } from "@next/font/google";
import styles from "./page.module.css";
import SignUpForm from "./authentication/register";
import LogInForm from "./authentication/logIn";

const inter = Inter({ subsets: ["latin"] });

export default function Home() {
  return <LogInForm />;
}
