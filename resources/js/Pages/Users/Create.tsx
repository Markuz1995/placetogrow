import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import Form from "./Components/Form";
import { Role } from "@/types/user";

interface CreateProps {
    auth: any;
    roles: Role[];
}

export default function Create({ auth, roles }: Readonly<CreateProps>) {
    const { data, setData, post, errors } = useForm({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        roles: [] as number[],
    });

    const onSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route("users.store"));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Create new user
                    </h2>
                </div>
            }
        >
            <Head title="Create User" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Form
                            data={data}
                            setData={setData}
                            errors={errors}
                            onSubmit={onSubmit}
                            isEditing={false}
                            roles={roles}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
