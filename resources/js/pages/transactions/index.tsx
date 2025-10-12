import { Head, router } from '@inertiajs/react';
import { PlusIcon } from 'lucide-react';
import Heading from '../../components/heading';
import { Button } from '../../components/ui/button';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '../../components/ui/table';
import AppLayout from '../../layouts/app-layout';
import { formatDate } from '../../lib/utils';
import { create, index } from '../../routes/transactions';
import { BreadcrumbItem, PaginateData, Transaction } from '../../types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Transactions',
        href: index().url,
    },
];

interface TransactionsIndexProps {
    transactions: PaginateData<Transaction>;
}

export default function TransactionsIndexPage({
    transactions,
}: TransactionsIndexProps) {
    const goToAddTransactionPage = () => {
        router.visit(create().url);
    };
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Transactions" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Heading
                    title="Transactions"
                    description="All my transactions transactions"
                />

                <div className="flex w-full justify-end">
                    <Button onClick={goToAddTransactionPage}>
                        <PlusIcon />
                        Add Expense
                    </Button>
                </div>

                <div className="grid grid-cols-3">
                    <div className="col-span-2">
                        <div className="flex flex-col gap-4">
                            <Table>
                                <TableCaption>
                                    A list of my recent transactions
                                </TableCaption>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>#</TableHead>
                                        <TableHead>Date</TableHead>
                                        <TableHead>Description</TableHead>
                                        <TableHead>Category</TableHead>
                                        <TableHead>Account</TableHead>
                                        <TableHead className="text-right">
                                            Amount
                                        </TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {transactions.data.map((transaction) => (
                                        <TableRow key={transaction.id}>
                                            <TableCell>
                                                {transaction.id}
                                            </TableCell>
                                            <TableCell>
                                                {formatDate(transaction.date)}
                                            </TableCell>
                                            <TableCell>
                                                {transaction.description}
                                            </TableCell>
                                            <TableCell>
                                                {transaction.category?.name}
                                            </TableCell>
                                            <TableCell>
                                                {transaction.account?.name}
                                            </TableCell>
                                            <TableCell className="text-right">
                                                INR {transaction.amount}
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </div>
                    </div>
                    <div></div>
                </div>
            </div>
        </AppLayout>
    );
}
