import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { IndexProps, Microsite } from "@/types/microsite";
import { Button } from "@headlessui/react";
import { Head, Link, router } from "@inertiajs/react";
import { useState } from "react";

export default function Index({ auth, microsites, success }: Readonly<IndexProps>) {

    const isAdmin = auth.user?.roles?.find(role => role.name === 'admin') !== undefined;

    const [showSuccessMessage, setShowSuccessMessage] = useState(!!success);

    const deleteMicrosite = (microsite: Microsite) => {
        if (!window.confirm('Are you sure you want to delete the microsite?')) {
            return false;
        }

        router.delete(route('microsite.destroy', microsite.id));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
                    <Link href={route('microsite.create')} className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600">
                        Add New
                    </Link>
                </div>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {showSuccessMessage && (
                        <div className="bg-emerald-500 py-2 px-4 text-white rounded mb-4 flex justify-between items-center">
                            <span>{success}</span>
                            <button onClick={() => setShowSuccessMessage(false)} className="text-white ml-4">
                                &times;
                            </button>
                        </div>
                    )}
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                                {microsites.data.map((microsite) => (
                                    <div key={microsite.id} className="bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col">
                                        <Link href={route('microsite.payment_records.index', microsite.id)} className="flex flex-col items-center p-4 text-center cursor-pointer hover:bg-gray-50 transition duration-150">
                                            {microsite.logo ? (
                                                <img src={typeof microsite.logo === 'string' ? microsite.logo : undefined} alt="Logo" className="w-16 h-16 mb-2" />
                                            ) : (
                                                <div className="w-16 h-16 mb-2 bg-gray-200 rounded-full flex items-center justify-center">
                                                    No Logo
                                                </div>
                                            )}
                                            <h3 className="text-lg font-semibold">{microsite.name}</h3>
                                        </Link>
                                        <div className="p-4 border-t border-gray-200">
                                            <div className="flex justify-between">
                                                <p className="text-sm font-medium text-gray-700">Category</p>
                                                <p className="text-sm text-gray-600">{microsite.category?.name}</p>
                                            </div>
                                            <div className="flex justify-between">
                                                <p className="text-sm font-medium text-gray-700">Currency</p>
                                                <p className="text-sm text-gray-600">{microsite.currency}</p>
                                            </div>
                                            <div className="flex justify-between">
                                                <p className="text-sm font-medium text-gray-700">Payment Expiration</p>
                                                <p className="text-sm text-gray-600">{microsite.payment_expiration}</p>
                                            </div>
                                            <div className="flex justify-between">
                                                <p className="text-sm font-medium text-gray-700">Type</p>
                                                <p className="text-sm text-gray-600">{microsite.type}</p>
                                            </div>
                                        </div>
                                        <div className="border-t border-gray-200 mt-2"></div>
                                        <div className="mt-2 flex justify-between px-4 pb-4">
                                            <Link href={route('microsite.show', microsite.id)} className="font-medium text-green-600 hover:underline">
                                                Show
                                            </Link>
                                            {isAdmin && (
                                                <>
                                                    <Link href={route('microsite.edit', microsite.id)} className="font-medium text-blue-600 hover:underline">
                                                        Edit
                                                    </Link>
                                                    <Button onClick={(e) => deleteMicrosite(microsite)} className="font-medium text-red-600 hover:underline">
                                                        Delete
                                                    </Button>
                                                </>
                                            )}
                                        </div>
                                    </div>
                                ))}
                            </div>
                            <div className="mt-4 flex justify-center">
                                <Pagination links={microsites.links} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
