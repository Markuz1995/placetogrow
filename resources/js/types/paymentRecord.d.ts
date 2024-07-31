import { User } from "./user";

export interface PaymentRecord {
    id: number;
    reference: string;
    type: string;
    amount: number;
    due_date?: string;
}

export type IndexProps = {
    auth: {
        user: User;
    };
    micrositeId: number;
    paymentRecords: {
        data: PaymentRecord[];
        links: any;
    };
    success?: string;
};
