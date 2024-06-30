import { PageProps } from '@/types';

interface Category {
    id: number;
    name: string;
}

interface IndexProps extends PageProps {
    categories: {
        data: Category[];
        links: any[];
    };
    success?: string;
}

interface CategoryFormData {
    name: string;
}

interface CategoryFormProps {
    data: CategoryFormData;
    setData: (field: keyof CategoryFormData, value: string) => void;
    errors: {
        name?: string;
    };
    onSubmit: (e: React.FormEvent<HTMLFormElement>) => void;
    isEditing: boolean;
}

interface Auth {
    user: {
        id: number;
        name: string;
        email: string;
    };
}

interface EditProps extends PageProps {
    category: Category;
}

export interface ShowProps extends PageProps {
    category: Category;
}
