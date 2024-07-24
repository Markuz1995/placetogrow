import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import Form from "./Components/Form";
import { Permission } from "@/types/user";

interface CreateProps {
    auth: any;
    permissions: Permission[];
}

export default function Create({ auth, permissions }: Readonly<CreateProps>) {
    const { data, setData, post, errors } = useForm({
        name: "",
        permissions: [] as number[],
    });

    const onSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route("roles.store"));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Create new role
                    </h2>
                </div>
            }
        >
            <Head title="Create Role" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Form
                            data={data}
                            setData={setData}
                            errors={errors}
                            onSubmit={onSubmit}
                            isEditing={false}
                            permissions={permissions}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
