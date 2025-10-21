import { Head } from "@inertiajs/react";
import AppLayout from "../../layouts/app-layout";
import Heading from "../../components/heading";
import { Account, BreadcrumbItem } from "../../types";
import { index } from "../../routes/accounts";
import AccountForm from "../../forms/account-form";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Accounts',
        href: index().url,
    },
    {
        title: 'Add Account',
        href: '#',
    },
];

interface AccountsCreateProps {
    account: Account;
}

export default function AccountsCreatePage({ account }: AccountsCreateProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Add Account" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Heading title="Add Account" description="Add a new account" />

                <div className="grid grid-cols-4">
                    <div className="col-span-3 lg:col-span-2">
                        <div className="flex flex-col gap-4">
                            <AccountForm account={account} />
                        </div>
                    </div>
                    <div></div>
                </div>
            </div>
        </AppLayout>
    );
}
