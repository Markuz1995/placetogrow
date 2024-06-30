import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import Form from "./Components/Form";
import { CreateProps } from "@/types/microsite";

export default function Create({ auth, categories, types, currency }: Readonly<CreateProps>) {
    const { data, setData, post, errors } = useForm({
        name: "",
        category_id: 0,
        currency: "",
        payment_expiration: 0,
        type: "",
        logo: null,
    });

    const onSubmit = (e: { preventDefault: () => void; }) => {
        e.preventDefault();
        post(route("microsite.store"));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Create new microsite
                    </h2>
                </div>
            }
        >
            <Head title="Create Microsite" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Form
                            data={data}
                            setData={setData}
                            errors={errors}
                            onSubmit={onSubmit}
                            isEditing={false}
                            categories={categories}
                            types={types}
                            currency={currency}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
