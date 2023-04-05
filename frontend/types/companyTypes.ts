import {UserData} from "~/types/userTypes";

export type Company = {
    id: number;
    title: string;
    description: string | null;
    logo_path: string | null;
    created_at: string | null;
    updated_at: string | null;
    deleted_at: string | null;
    user?: UserData
  };
  