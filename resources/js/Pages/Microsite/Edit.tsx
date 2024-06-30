import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import Form from "./Components/Form";
import { EditProps } from "@/types/microsite";

export default function Edit({ auth, microsite, categories, types, currency }: Readonly<EditProps>) {

    const { data, setData, post, errors } = useForm({
        name: microsite.name || "",
        category_id: microsite.category_id || 0,
        currency: microsite.currency || "",
        payment_expiration: microsite.payment_expiration || 0,
        type: microsite.type || "",
        logo: microsite.logo ?? null,
        _method: "PUT",
    });

    const onSubmit = (e: { preventDefault: () => void; }) => {
        e.preventDefault();
        post(route("microsite.update", microsite.id));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Edit microsite "{microsite.name}"
                    </h2>
                </div>
            }
        >
            <Head title="Edit Microsite" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Form
                            data={data}
                            setData={setData}
                            errors={errors}
                            onSubmit={onSubmit}
                            isEditing={true}
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
