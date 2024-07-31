import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { PaymentRecord, IndexProps } from "@/types/paymentRecord";
import { Head, Link, router } from "@inertiajs/react";
import { Button } from "@headlessui/react";
import { useState } from "react";

export default function Index({ auth, micrositeId, paymentRecords, success }: Readonly<IndexProps>) {
    const [showSuccessMessage, setShowSuccessMessage] = useState(!!success);

    const isAdmin = auth.user?.roles?.find(role => role.name === 'admin') !== undefined;

    const deletePaymentRecord = (paymentRecord: PaymentRecord) => {
        if (!window.confirm('Are you sure you want to delete the payment record?')) {
            return false;
        }

        router.delete(route('microsite.payment_records.destroy', { microsite: micrositeId, payment_record: paymentRecord.id }));
    };


    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">Payment Records</h2>
                    <Link href={route('microsite.payment_records.create', micrositeId)} className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600">
                        Add New
                    </Link>
                </div>
            }
        >
            <Head title="Payment Records" />

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
                                {paymentRecords.data.map((paymentRecord) => (
                                    <div key={paymentRecord.id} className="bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col">
                                        <div className="flex flex-col items-center p-4 text-center cursor-pointer hover:bg-gray-50 transition duration-150">
                                            <h3 className="text-lg font-semibold">{paymentRecord.reference}</h3>
                                            <p className="text-sm text-gray-600">Type: {paymentRecord.type}</p>
                                            <p className="text-sm text-gray-600">Amount: ${paymentRecord.amount}</p>
                                            <p className="text-sm text-gray-600">Due Date: {paymentRecord.due_date}</p>
                                        </div>
                                        <div className="border-t border-gray-200 mt-2"></div>
                                        <div className="mt-2 flex justify-between px-4 pb-4">
                                            {isAdmin && (
                                                <>
                                                    <Link href={route('microsite.payment_records.edit', { microsite: micrositeId, payment_record: paymentRecord.id })} className="font-medium text-blue-600 hover:underline">
                                                        Edit
                                                    </Link>
                                                    <Button onClick={(e) => deletePaymentRecord(paymentRecord)} className="font-medium text-red-600 hover:underline">
                                                        Delete
                                                    </Button>
                                                </>
                                            )}

                                        </div>
                                    </div>
                                ))}
                            </div>
                            <div className="mt-4 flex justify-center">
                                <Pagination links={paymentRecords.links} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
