import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import Form from "./Components/Form";
import { User, Role } from "@/types/user";

interface EditProps {
    auth: any;
    user: User;
    roles: Role[];
}

export default function Edit({ auth, user, roles }: Readonly<EditProps>) {
    const { data, setData, put, errors } = useForm({
        name: user.name || '',
        email: user.email || '',
        password: '',
        password_confirmation: '',
        roles: user && user.roles ? user.roles.map(role => role.id) : [],
    });

    const onSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('users.update', user.id));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Edit User
                    </h2>
                </div>
            }
        >
            <Head title="Edit User" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Form
                            data={data}
                            setData={setData}
                            errors={errors}
                            onSubmit={onSubmit}
                            isEditing={true}
                            roles={roles}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
