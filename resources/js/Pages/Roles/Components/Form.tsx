import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import { RoleFormProps } from "@/types/user";
import { Link } from "@inertiajs/react";

export default function Form({ data, setData, errors, onSubmit, isEditing, permissions }: Readonly<RoleFormProps>) {
    return (
        <form onSubmit={onSubmit} className="p-4 sm:p-8 shadow sm:rounded-lg">
            <div>
                <InputLabel htmlFor="role_name" value="Name" />
                <TextInput
                    id="role_name"
                    type="text"
                    name="name"
                    value={data.name}
                    className="mt-1 block w-full"
                    isFocused={true}
                    onChange={(e) => setData("name", e.target.value)}
                />
                <InputError message={errors.name} className="mt-2" />
            </div>

            <div className="mt-4">
                <InputLabel htmlFor="role_permissions" value="Permissions" />
                <select
                    id="role_permissions"
                    name="permissions"
                    value={data.permissions}
                    onChange={(e) => setData("permissions", Array.from(e.target.selectedOptions, option => parseInt(option.value)))}
                    className="mt-1 block w-full"
                    multiple
                >
                    {permissions.map(permission => (
                        <option key={permission.id} value={permission.id}>{permission.name}</option>
                    ))}
                </select>
                <InputError message={errors.permissions} className="mt-2" />
            </div>

            <div className="mt-4 text-right">
                <Link
                    href={route("roles.index")}
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
