import User from "@/App/Types/user";

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
    };
    isCentral: boolean;
};

export type OptionData = {
    optionId: number;
    name: {
        en: string,
        bn: string
    };
    values: string;
    createdOn: string;
    position: number;
    handle: string;
    category_id: number;
};

export type DropdownData = {
    value: number;
    label: string;
};
