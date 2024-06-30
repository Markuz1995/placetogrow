import { useEffect } from 'react';
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import SelectInput from "@/Components/SelectInput";
import { Link } from "@inertiajs/react";

const transformOptions = (options) => {
    return options.map(option => ({ id: option, name: option }));
};

export default function MicrositeForm({ data, setData, errors, onSubmit, isEditing, categories, types, currency }) {
    let logoUrl = null;

    useEffect(() => {
        return () => {
            if (logoUrl) {
                URL.revokeObjectURL(logoUrl);
                logoUrl = null;
            }
        };
    }, [data.logo]);

    if (data.logo) {
        if (typeof data.logo === 'string') {
            logoUrl = '/' + data.logo;
        } else {
            logoUrl = URL.createObjectURL(data.logo);
        }
    }

    const transformedTypes = transformOptions(types);
    const transformedCurrencies = transformOptions(currency);
    console.log(transformedTypes);
    console.log(transformedCurrencies);

    return (
        <form onSubmit={onSubmit} className="p-4 sm:p-8 shadow sm:rounded-lg" encType="multipart/form-data">
            <div className="mb-4">
                <InputLabel htmlFor="microsite_name" value="Name" />
                <TextInput
                    id="microsite_name"
                    type="text"
                    name="name"
                    value={data.name}
                    className="mt-1 block w-full"
                    onChange={(e) => setData("name", e.target.value)}
                />
                <InputError message={errors.name} className="mt-2" />
            </div>

            {logoUrl && (
                <div className="mb-4">
                    <img src={logoUrl} className="w-64" alt="Logo Preview" />
                </div>
            )}

            <div>
                <InputLabel htmlFor="microsite_logo" value="Logo" />
                <TextInput
                    id="microsite_logo"
                    type="file"
                    name="logo"
                    className="mt-1 block w-full"
                    onChange={(e) => setData("logo", e.target.files[0])}
                />
                <InputError message={errors.logo} className="mt-2" />
            </div>

            <div className="mt-4">
                <InputLabel htmlFor="category_id" value="Category" />
                <SelectInput
                    id="category_id"
                    name="category_id"
                    value={data.category_id}
                    className="mt-1 block w-full"
                    onChange={(e) => setData("category_id", e.target.value)}
                    options={categories}
                />
                <InputError message={errors.category_id} className="mt-2" />
            </div>

            <div className="mt-4">
                <InputLabel htmlFor="currency" value="Currency" />
                <SelectInput
                    id="currency"
                    name="currency"
                    value={data.currency}
                    className="mt-1 block w-full"
                    onChange={(e) => setData("currency", e.target.value)}
                    options={transformedCurrencies}
                />
                <InputError message={errors.currency} className="mt-2" />
            </div>

            <div className="mt-4">
                <InputLabel htmlFor="payment_expiration" value="Payment Expiration (days)" />
                <TextInput
                    id="payment_expiration"
                    type="number"
                    name="payment_expiration"
                    value={data.payment_expiration}
                    className="mt-1 block w-full"
                    onChange={(e) => setData("payment_expiration", e.target.value)}
                />
                <InputError message={errors.payment_expiration} className="mt-2" />
            </div>

            <div className="mt-4">
                <InputLabel htmlFor="type" value="Type" />
                <SelectInput
                    id="type"
                    name="type"
                    value={data.type}
                    className="mt-1 block w-full"
                    onChange={(e) => setData("type", e.target.value)}
                    options={transformedTypes}
                />
                <InputError message={errors.type} className="mt-2" />
            </div>

            <div className="mt-4 text-right">
                <Link
                    href={route("microsite.index")}
                    className="bg-gray-100 py-1 px-3 text-gray-800 rounded shadow transition-all hover:bg-gray-200 mr-2"
                >
                    Cancel
                </Link>
                <button className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600">
                    {isEditing ? "Update" : "Submit"}
                </button>
            </div>
        </form>
    );
}
