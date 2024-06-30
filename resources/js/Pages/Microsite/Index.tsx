import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { IndexProps, Microsite } from "@/types/microsite";
import { Button } from "@headlessui/react";
import { Head, Link, router } from "@inertiajs/react";
import { useState } from "react";

export default function Index({ auth, microsites, success }: Readonly<IndexProps>) {

    const [showSuccessMessage, setShowSuccessMessage] = useState(!!success);
    const [modalImage, setModalImage] = useState<string | null>(null);


    const deleteMicrosite = (microsite: Microsite) => {
        if (!window.confirm('Are you sure you want to delete the microsite?')) {
            return false;
        }

        router.delete(route('microsite.destroy', microsite.id));
    };

    const openModal = (imageUrl: string | File) => {
        if (typeof imageUrl === 'string') {
            setModalImage(imageUrl);
        } else {
            const reader = new FileReader();
            reader.onload = (e) => {
                if (e.target && typeof e.target.result === 'string') {
                    setModalImage(e.target.result);
                }
            };
            reader.readAsDataURL(imageUrl);
        }
    };

    const closeModal = () => {
        setModalImage(null);
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
                            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                    <tr>
                                        <th className="px-3 py-2">ID</th>
                                        <th className="px-3 py-2">Name</th>
                                        <th className="px-3 py-2">Logo</th>
                                        <th className="px-3 py-2">Category</th>
                                        <th className="px-3 py-2">Currency</th>
                                        <th className="px-3 py-2">Payment Expiration</th>
                                        <th className="px-3 py-2">Type</th>
                                        <th className="px-3 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {microsites.data.map((microsite, index) => (
                                        <tr key={microsite.id} className="bg-white border-b dark:border-gray-700">
                                            <td className="px-3 py-2">{index + 1}</td>
                                            <td className="px-3 py-2">{microsite.name}</td>
                                            <td className="px-3 py-2">
                                                {microsite.logo && (
                                                    <button onClick={() => openModal(microsite.logo)} className="bg-transparent border-none">
                                                        {typeof microsite.logo === 'string' ? (
                                                            <img src={microsite.logo} alt="Logo" className="w-8 h-8 cursor-pointer" />
                                                        ) : (
                                                            <span>No Logo</span>
                                                        )}
                                                    </button>
                                                )}
                                            </td>
                                            <td className="px-3 py-2">{microsite.category?.name}</td>
                                            <td className="px-3 py-2">{microsite.currency}</td>
                                            <td className="px-3 py-2">{microsite.payment_expiration}</td>
                                            <td className="px-3 py-2">{microsite.type}</td>
                                            <td className="px-3 py-2">
                                                <Link
                                                    href={route('microsite.edit', microsite.id)}
                                                    className="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                                >
                                                    Edit
                                                </Link>
                                                <Button
                                                    onClick={(e) => deleteMicrosite(microsite)}
                                                    className="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
                                                >
                                                    Delete
                                                </Button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                            {modalImage && (
                                <div className="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50">
                                    <div className="relative max-w-3xl mx-auto">
                                        <button onClick={closeModal} className="absolute top-4 right-4 text-white text-2xl">&times;</button>
                                        <img src={modalImage} alt="Modal Image" className="max-w-full max-h-full" />
                                    </div>
                                </div>
                            )}
                            <div className="mt-4">
                                <Pagination links={microsites.links} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
