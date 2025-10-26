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
import { show } from '../routes/accounts';
import { Account, PaginateData } from '../types';

interface AccountsTableProps {
    accounts: PaginateData<Account>;
    fullView?: boolean;
}

export default function AccountsTable({
    accounts,
    fullView = true,
}: AccountsTableProps) {
    return (
        <Table>
            <TableCaption>A list of my accounts</TableCaption>
            <TableHeader>
                <TableRow>
                    {fullView && <TableHead>#</TableHead>}
                    {fullView && <TableHead>Date</TableHead>}
                    <TableHead>Name</TableHead>
                    {fullView && <TableHead>Type</TableHead>}
                    {fullView && <TableHead>Status</TableHead>}
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
                        {fullView && <TableCell>{account.id}</TableCell>}
                        {fullView && (
                            <TableCell>
                                {formatDate(account.created_at)}
                            </TableCell>
                        )}
                        <TableCell>{account.name}</TableCell>
                        {fullView && (
                            <TableCell className="capitalize">
                                {account.type}
                            </TableCell>
                        )}
                        {fullView && (
                            <TableCell>
                                {account.is_active ? 'Active' : 'Inactive'}
                            </TableCell>
                        )}
                        <TableCell className="text-right">
                            INR {account.balance}
                        </TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}
