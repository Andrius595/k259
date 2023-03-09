import {H3Event} from "h3";
import {ServerSideResponse} from "~/types/generalTypes";

export default defineEventHandler(async (event: H3Event): Promise<ServerSideResponse> => {
    const runtimeConfig = useRuntimeConfig();

    setCookie(event, runtimeConfig.public.authCookieName, '', {httpOnly: true});

    return {status: true, data: null}
});
