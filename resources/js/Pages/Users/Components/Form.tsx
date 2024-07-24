import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import { UserFormProps } from "@/types/user";
import { Link } from "@inertiajs/react";

export default function Form({ data, setData, errors, onSubmit, isEditing, roles }: Readonly<UserFormProps>) {
    return (
        <form onSubmit={onSubmit} className="p-4 sm:p-8 shadow sm:rounded-lg">
            <div>
                <InputLabel htmlFor="user_name" value="Name" />
                <TextInput
                    id="user_name"
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
                <InputLabel htmlFor="user_email" value="Email" />
                <TextInput
                    id="user_email"
                    type="email"
                    name="email"
                    value={data.email}
                    className="mt-1 block w-full"
                    onChange={(e) => setData("email", e.target.value)}
                />
                <InputError message={errors.email} className="mt-2" />
            </div>

            <div className="mt-4">
                <InputLabel htmlFor="user_password" value="Password" />
                <TextInput
                    id="user_password"
                    type="password"
                    name="password"
                    value={data.password}
                    className="mt-1 block w-full"
                    onChange={(e) => setData("password", e.target.value)}
                />
                <InputError message={errors.password} className="mt-2" />
            </div>

            <div className="mt-4">
                <InputLabel htmlFor="user_password_confirmation" value="Confirm Password" />
                <TextInput
                    id="user_password_confirmation"
                    type="password"
                    name="password_confirmation"
                    value={data.password_confirmation}
                    className="mt-1 block w-full"
                    onChange={(e) => setData("password_confirmation", e.target.value)}
                />
                <InputError message={errors.password_confirmation} className="mt-2" />
            </div>

            <div className="mt-4">
                <InputLabel htmlFor="user_roles" value="Roles" />
                <select
                    id="user_roles"
                    name="roles"
                    value={data.roles}
                    onChange={(e) => setData("roles", Array.from(e.target.selectedOptions, option => parseInt(option.value)))}
                    className="mt-1 block w-full"
                    multiple
                >
                    {roles.map(role => (
                        <option key={role.id} value={role.id}>{role.name}</option>
                    ))}
                </select>
                <InputError message={errors.roles} className="mt-2" />
            </div>

            <div className="mt-4 text-right">
                <Link
                    href={route("users.index")}
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
