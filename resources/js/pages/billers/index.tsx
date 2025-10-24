import { Head, router } from '@inertiajs/react';
import { PlusIcon } from 'lucide-react';
import Heading from '../../components/heading';
import { Button } from '../../components/ui/button';
import AppLayout from '../../layouts/app-layout';
import { create, index } from '../../routes/billers';
import { Biller, BreadcrumbItem, PaginateData } from '../../types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Billers',
        href: index().url,
    },
];

interface BillersIndexProps {
    billers: PaginateData<Biller>;
}

export default function BillersIndexPage({ billers }: BillersIndexProps) {
    const goToAddBillerPage = () => {
        router.visit(create().url);
    };
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Billers" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Heading title="Billers" description="All my billers" />

                <div className="flex w-full justify-end">
                    <Button onClick={goToAddBillerPage}>
                        <PlusIcon />
                        Add Biller
                    </Button>
                </div>

                <div className="grid grid-cols-3">
                    <div className="col-span-2">
                        <div className="flex flex-col gap-4"></div>
                    </div>
                    <div></div>
                </div>
            </div>
        </AppLayout>
    );
}
