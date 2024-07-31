import { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Role } from '@/types/role';
import Pagination from '@/Components/Pagination';

interface IndexProps {
    auth: any;
    roles: {
        data: Role[];
        links: any;
    };
    success: string;
}

const RolesIndex = ({ auth, roles, success }: IndexProps) => {
    const [showSuccessMessage, setShowSuccessMessage] = useState(!!success);

    const deleteRole = (role: Role) => {
        if (!window.confirm('Are you sure you want to delete the role?')) {
            return false;
        }

        router.delete(route('roles.destroy', role.id))
    };

    return (
        <AuthenticatedLayout user={auth.user} header={<div className="flex justify-between items-center">
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">List of Roles</h2>
            <Link href={route('roles.create')} className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600">
                Add new
            </Link>
        </div>}>
            <Head title="Roles" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {showSuccessMessage && (
                        <div className="bg-emerald-500 py-2 px-4 text-white rounded mb-4 flex justify-between items-center">
                            <span>{success}</span>
                            <button onClick={() => setShowSuccessMessage(false)} className="text-white ml-4">&times;</button>
                        </div>
                    )}
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                    <tr>
                                        <th className="px-3 py-2">ID</th>
                                        <th className="px-3 py-2">Name</th>
                                        <th className="px-3 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {roles.data.map((role, index) => (
                                        <tr key={role.id} className="bg-white border-b dark:border-gray-700">
                                            <td className="px-3 py-2">{index + 1}</td>
                                            <td className="px-3 py-2">{role.name}</td>
                                            <td className="px-3 py-2">
                                                <Link href={route('roles.edit', role.id)} className="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1">Edit</Link>
                                                <button onClick={() => deleteRole(role)} className="font-medium text-red-600 dark:text-red-500 hover:underline mx-1">Delete</button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                            <div className="mt-4">
                                <Pagination links={roles.links} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default RolesIndex;
