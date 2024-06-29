import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import Form from "./Components/Form";

export default function Edit({ auth, category }) {
    const { data, setData, put, errors } = useForm({
        name: category.name || "",
    });

    const onSubmit = (e) => {
        e.preventDefault();
        put(route("category.update", category.id));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Edit category "{category.name}"
                    </h2>
                </div>
            }
        >
            <Head title="Edit Category" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Form
                            data={data}
                            setData={setData}
                            errors={errors}
                            onSubmit={onSubmit}
                            isEditing={true}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
