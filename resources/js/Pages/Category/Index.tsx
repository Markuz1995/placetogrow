import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { IndexProps, Category } from "@/types/category";
import { Button } from "@headlessui/react";
import { Head, Link, router } from "@inertiajs/react";
import { useState } from "react";

export default function Index({ auth, categories, success }: Readonly<IndexProps>) {

    const [showSuccessMessage, setShowSuccessMessage] = useState(!!success);

    const deleteCategory = (category: Category) => {
        if (!window.confirm('Are you sure you want to delete the category?')) {
            return false;
        }

        router.delete(route('category.destroy', category.id))
    }
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
                    <Link href={route('category.create')} className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600">
                        Add new
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
                            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:test-gray-400">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                    <tr className="text-nowrap">
                                        <th className="px-3 py-2">ID</th>
                                        <th className="px-3 py-2">Name</th>
                                        <th className="px-3 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {categories.data.map((category, index) => (
                                        <tr key={category.id} className="bg-white border-b dark:boder-gray-700">
                                            <td className="px-3 py-2">{index + 1}</td>
                                            <td className="px-3 py-2">{category.name}</td>
                                            <td className="px-3 py-2">
                                                <Link
                                                    href={route('category.show', category.id)}
                                                    className="font-medium text-green-600 dark:text-green-500 hover:underline mx-1"
                                                >
                                                    View
                                                </Link>
                                                <Link
                                                    href={route('category.edit', category.id)}
                                                    className="font-medium text-blue-600 dark:test-blue-500 hover:underline mx-1"
                                                >
                                                    Edit
                                                </Link>
                                                <Button
                                                    onClick={(e) => deleteCategory(category)}
                                                    className="font-medium text-red-600 dark:test-red-500 hover:underline mx-1"
                                                >
                                                    Delete
                                                </Button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                            <div className="mt-4">
                                <Pagination links={categories.links} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
