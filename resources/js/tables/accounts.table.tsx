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
import { PaginateData, Account } from '../types';
import { show } from '../routes/accounts';

interface AccountsTableProps {
    accounts: PaginateData<Account>;
}

export default function AccountsTable({accounts}: AccountsTableProps) {
    return <Table>
    <TableCaption>A list of my accounts</TableCaption>
    <TableHeader>
        <TableRow>
            <TableHead>#</TableHead>
            <TableHead>Date</TableHead>
            <TableHead>Name</TableHead>
            <TableHead>Type</TableHead>
            <TableHead>Status</TableHead>
            <TableHead className="text-right">Balance</TableHead>
        </TableRow>
    </TableHeader>
    <TableBody>
        {accounts.data.map((account) => (
            <TableRow
                key={account.id}
                onClick={() => router.visit(show(account.id).url)}
                className="cursor-pointer"
            >
                <TableCell>{account.id}</TableCell>
                <TableCell>{formatDate(account.created_at)}</TableCell>
                <TableCell>{account.name}</TableCell>
                <TableCell className='capitalize'>{account.type}</TableCell>
                <TableCell>{account.is_active ? 'Active' : 'Inactive'}</TableCell>
                <TableCell className="text-right">
                    INR {account.balance}
                </TableCell>
            </TableRow>
        ))}
    </TableBody>
</Table>
}
