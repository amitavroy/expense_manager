import { router } from '@inertiajs/react';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '../components/ui/table';
import { formatDate } from '../lib/utils';
import { PaginateData, Transaction } from '../types';
import { show } from '../routes/transactions';

interface TransactionsTableProps {
    transactions: PaginateData<Transaction>;
}

export default function TransactionsTable({ transactions }: TransactionsTableProps) {
    return (
        <Table>
            <TableCaption>A list of my recent transactions</TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead>#</TableHead>
                    <TableHead>Date</TableHead>
                    <TableHead>Description</TableHead>
                    <TableHead>Category</TableHead>
                    <TableHead>Account</TableHead>
                    <TableHead className="text-right">Amount</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                {transactions.data.map((transaction) => (
                    <TableRow
                        key={transaction.id}
                        onClick={() => router.visit(show(transaction.id).url)}
                        className="cursor-pointer"
                    >
                        <TableCell>{transaction.id}</TableCell>
                        <TableCell>{formatDate(transaction.date)}</TableCell>
                        <TableCell>{transaction.description}</TableCell>
                        <TableCell>{transaction.category?.name}</TableCell>
                        <TableCell>{transaction.account?.name}</TableCell>
                        <TableCell className="text-right">
                            INR {transaction.amount}
                        </TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}


