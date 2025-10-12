import { Head } from '@inertiajs/react';
import Heading from '../../components/heading';
import TransactionAddForm from '../../forms/transaction-add-form';
import AppLayout from '../../layouts/app-layout';
import { index } from '../../routes/transactions';
import { BreadcrumbItem } from '../../types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Transactions',
        href: index().url,
    },
    {
        title: 'Add Transaction',
        href: '#',
    },
];

export interface AccountDropdown {
    id: number;
    name: string;
}

export interface CategoryDropdown {
    id: number;
    name: string;
}

interface TransactionsCreateProps {
    accounts: AccountDropdown[];
    categories: CategoryDropdown[];
}

export default function TransactionsCreatePage({
    accounts,
    categories,
}: TransactionsCreateProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Add Transaction" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Heading
                    title="Add Transaction"
                    description="Add a new transaction"
                />

                <div className="grid grid-cols-4">
                    <div className="col-span-3 lg:col-span-2">
                        <div className="flex flex-col gap-4">
                            <TransactionAddForm
                                accounts={accounts}
                                categories={categories}
                            />
                        </div>
                    </div>
                    <div></div>
                </div>
            </div>
        </AppLayout>
    );
}
