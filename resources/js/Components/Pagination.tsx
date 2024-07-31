import { Link } from "@inertiajs/react";

interface LinkItem {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginationProps {
    links: LinkItem[];
}

export default function Pagination({ links }: PaginationProps) {
    return (
        <div className="pagination">
            {links.map(link => (
                <Link
                    preserveScroll
                    href={link.url || ''}
                    key={link.label}
                    className={
                        "inline-block py-2 px-3 rounded-lg text-gray text-xs " +
                        (link.active ? "bg-gray-800 text-gray-200 hover:text-gray-200" : "") +
                        (!link.url ? " text-gray-500 cursor-not-allowed" : "")
                    }
                    dangerouslySetInnerHTML={{ __html: link.label }}
                />
            ))}
        </div>
    );
}
