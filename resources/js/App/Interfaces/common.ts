export interface BaseEntity {
    id: number;
    name: string;
}

export interface AuthUser {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Auth {
    user: AuthUser | null;
    role: string | null;
}

export interface FlashMessages {
    success: string | null;
    error: string | null;
}

export interface ZiggyRoute {
    uri: string;
    methods: string[];
    parameters?: string[];
}

export interface Ziggy {
    url: string;
    port: number | null;
    defaults: Record<string, unknown>;
    routes: Record<string, ZiggyRoute>;
    location: string;
}

export interface BasePageProps {
    errors: Record<string, string>;
    auth: Auth;
    session: Record<string, unknown>;
    flash: FlashMessages;
    ziggy: Ziggy;
}

export interface PageProps<T = Record<string, unknown>> extends BasePageProps {
    data?: T;
}

export interface Pagination {
    current_page: number;
    last_page: number;
    total: number;
}
