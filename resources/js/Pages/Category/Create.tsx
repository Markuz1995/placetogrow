import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import Form from "./Components/Form";
import { IndexProps } from "@/types/category";

export default function Create({ auth }: Readonly<IndexProps>) {
    const { data, setData, post, errors } = useForm({
        name: "",
    });

    const onSubmit = (e: { preventDefault: () => void; }) => {
        e.preventDefault();
        post(route("category.store"));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Create new category
                    </h2>
                </div>
            }
        >
            <Head title="Create Category" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Form
                            data={data}
                            setData={setData}
                            errors={errors}
                            onSubmit={onSubmit}
                            isEditing={false}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
