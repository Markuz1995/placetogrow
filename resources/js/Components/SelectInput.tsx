import { forwardRef, useEffect, useImperativeHandle, useRef, SelectHTMLAttributes } from 'react';

interface Option {
    id: string;
    name: string;
}

interface SelectInputProps extends SelectHTMLAttributes<HTMLSelectElement> {
    options: Option[];
    defaultOptionText?: string;
}

export default forwardRef(function SelectInput(
    { className = '', options = [], defaultOptionText = 'Select an option', ...props }: SelectInputProps,
    ref
) {
    const localRef = useRef<HTMLSelectElement>(null);

    useImperativeHandle(ref, () => ({
        focus: () => localRef.current?.focus(),
    }));

    return (
        <select
            {...props}
            className={
                'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ' +
                className
            }
            ref={localRef}
        >
            <option value="">{defaultOptionText}</option>
            {options.map(option => (
                <option key={option.id} value={option.id}>
                    {option.name}
                </option>
            ))}
        </select>
    );
});
