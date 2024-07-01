import { PageProps } from '@/types';

export interface Microsite {
    id: number;
    name: string;
    url: string;
    category_id: number;
    logo: string | File;
    currency: string;
    payment_expiration: number;
    type: string;
    category?: {
        id: string,
        name: string,
    }
}

export interface IndexProps extends PageProps {
    microsites: {
        data: Microsite[];
        links: any[];
    };
    success?: string;
}

export interface CreateProps extends IndexProps {
    isEditing: boolean;
    categories: { id: number; name: string }[];
    types: string[];
    currency: string[];
}

export interface MicrositeFormData {
    name: string;
    logo: string | File | null;
    category_id: number;
    currency: string;
    payment_expiration: number;
    type: string;
}

export interface MicrositeFormProps {
    data: MicrositeFormData;
    setData: (field: keyof MicrositeFormData, value: string | File | number) => void;
    errors: {
        name?: string;
        logo?: string;
        category_id?: string;
        currency?: string;
        payment_expiration?: string;
        type?: string;
    };
    onSubmit: (e: React.FormEvent<HTMLFormElement>) => void;
    isEditing: boolean;
    categories: { id: number; name: string }[];
    types: string[];
    currency: string[];
}

export interface Auth {
    user: {
        id: number;
        name: string;
        email: string;
    };
}

interface Option {
    id: string;
    name: string;
}

export interface EditProps extends PageProps {
    microsite: Microsite;
    isEditing: boolean;
    categories: { id: number; name: string }[];
    types: string[];
    currency: string[];
}

export interface ShowProps extends PageProps {
    microsite: Microsite;
}
