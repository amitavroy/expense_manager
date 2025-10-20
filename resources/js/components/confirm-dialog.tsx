import React from "react";
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from "@/components/ui/alert-dialog";

interface ConfirmDialogProps {
    title: string;
    description: string;
    confirmButtonText: string;
    trigger: React.ReactNode;
    onConfirm: () => void;
    onCancel?: () => void;
}

export function ConfirmDialog({ title, description, confirmButtonText, trigger, onConfirm, onCancel }: ConfirmDialogProps) {
    return (
        <AlertDialog>
        <AlertDialogTrigger asChild>{trigger}</AlertDialogTrigger>
        <AlertDialogContent>
            <AlertDialogHeader>
            <AlertDialogTitle>{title}</AlertDialogTitle>
            <AlertDialogDescription>{description}</AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
            <AlertDialogCancel onClick={onCancel}>Cancel</AlertDialogCancel>
            <AlertDialogAction onClick={onConfirm}>{confirmButtonText}</AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
        </AlertDialog>
    )
}
