import { useBackFetch } from "~/composables/useBackFetch";
import { H3Event, readBody } from "h3";
import { LoginCredentials } from "~/types/authTypes";

export default defineEventHandler(async (event: H3Event) => {
  const runtimeConfig = useRuntimeConfig();
  setCookie(event, runtimeConfig.public.authCookieName, ``, { httpOnly: true });
  return "Logged out";
});
