import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import Form from "./Components/Form";
import { Role, Permission } from "@/types/user";

interface EditProps {
    auth: any;
    role: Role;
    permissions: Permission[];
}

export default function Edit({ auth, role, permissions }: Readonly<EditProps>) {
    const { data, setData, put, errors } = useForm({
        name: role.name || '',
        permissions: role.permissions.map(permission => permission.id),
    });

    const onSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('roles.update', role.id));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Edit role
                    </h2>
                </div>
            }
        >
            <Head title="Edit Role" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Form
                            data={data}
                            setData={setData}
                            errors={errors}
                            onSubmit={onSubmit}
                            isEditing={true}
                            permissions={permissions}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
