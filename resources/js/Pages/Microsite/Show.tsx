import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import { ShowProps } from "@/types/microsite";

export default function Show({ auth, microsite }: Readonly<ShowProps>) {

    const getLogoUrl = (logo: string | File): string | undefined => {
        if (typeof logo === 'string') {
            return logo;
        }
        return undefined;
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        View Microsite "{microsite.name}"
                    </h2>
                </div>
            }
        >
            <Head title={`View Microsite ${microsite.name}`} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h3 className="text-lg font-medium text-gray-900">
                                Microsite Details
                            </h3>
                            <p className="mt-2 text-sm text-gray-600">
                                <strong>Name:</strong> {microsite.name}
                            </p>
                            <p className="mt-2 text-sm text-gray-600">
                                <strong>Category:</strong> {microsite.category?.name}
                            </p>
                            <p className="mt-2 text-sm text-gray-600">
                                <strong>Currency:</strong> {microsite.currency}
                            </p>
                            <p className="mt-2 text-sm text-gray-600">
                                <strong>Payment Expiration:</strong> {microsite.payment_expiration}
                            </p>
                            <p className="mt-2 text-sm text-gray-600">
                                <strong>Type:</strong> {microsite.type}
                            </p>
                            {microsite.logo && (
                                <div className="mt-2 text-sm text-gray-600">
                                    <strong>Logo:</strong>
                                    {typeof microsite.logo === 'string' ? (
                                        <img src={getLogoUrl('/' + microsite.logo)} alt="Microsite Logo" className="mt-2 w-full max-w-lg h-auto object-contain" />
                                    ) : (
                                        <span>Logo not available</span>
                                    )}
                                </div>
                            )}

                            <div className="mt-4 text-right">
                                <Link
                                    href={route("microsite.index")}
                                    className="bg-gray-100 py-1 px-3 text-gray-800 rounded shadow transition-all hover:bg-gray-200 mr-2"
                                >
                                    Back
                                </Link>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
