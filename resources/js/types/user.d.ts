export interface User {
    id: number;
    name: string;
    email: string;
    roles: Role[];
}

export interface Role {
    id: number;
    name: string;
    permissions: Permission[];
}

export interface Permission {
    id: number;
    name: string;
}

export interface UserFormProps {
    data: UserFormData;
    setData: (field: string, value: any) => void;
    errors: Record<string, string>;
    onSubmit: (e: React.FormEvent) => void;
    isEditing: boolean;
    roles: Role[];
}

export interface UserFormData {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
    roles: number[];
}

export interface RoleFormProps {
    data: RoleFormData;
    setData: (field: string, value: any) => void;
    errors: Record<string, string>;
    onSubmit: (e: React.FormEvent) => void;
    isEditing: boolean;
    permissions: Permission[];
}

export interface RoleFormData {
    name: string;
    permissions: number[];
}
