import {
    REGEX_FOR_EMAIL_VALIDATION,
    REGEX_FOR_PHONE_NUMBER_VALIDATION,
} from '@/App/Utils/regex';
import { ToastPosition, ToastType, useToast } from 'vue-toast-notification';

const toast = useToast();

export const Toast = {
    Success: (
        message: string,
        duration: number = 3000,
        position: ToastPosition = 'top-right',
    ) => openToaster(message, 'success', duration, position),
    Info: (
        message: string,
        duration: number = 3000,
        position: ToastPosition = 'top-right',
    ) => openToaster(message, 'info', duration, position),
    Warning: (
        message: string,
        duration: number = 3000,
        position: ToastPosition = 'top-right',
    ) => openToaster(message, 'warning', duration, position),
    Error: (
        message: string,
        duration: number = 3000,
        position: ToastPosition = 'top-right',
    ) => openToaster(message, 'error', duration, position),
};

const openToaster = (
    message: string,
    type: ToastType,
    duration?: number,
    position?: ToastPosition,
) => {
    return toast.open({
        message,
        type: type,
        duration,
        position,
    });
};

export const showToast = (
    type: ToastType = 'success',
    message: string = 'Toast message',
    duration: number = 3000,
    position: ToastPosition = 'top-right',
) => {
    toast.open({
        message: message,
        type: type,
        duration: duration,
        position: position,
    });
};

export const formatDate = (
    dateString: string,
    locale: string = 'en-Us',
    options: Intl.DateTimeFormatOptions = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    },
) => {
    const date = new Date(dateString);

    const dateOptions: Intl.DateTimeFormatOptions = options;

    return new Intl.DateTimeFormat(locale, dateOptions).format(date);
};

export const formatDateTime = (dateTime: string | Date | number): string => {
    const options: Intl.DateTimeFormatOptions = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true,
    };
    return new Date(dateTime).toLocaleDateString(undefined, options);
};

export const phoneNumberValidation = (number: string | number): boolean => {
    if (number === '') {
        return false;
    }

    if (REGEX_FOR_PHONE_NUMBER_VALIDATION.test(String(number))) {
        return false;
    }

    return true;
};

export const emailValidation = (email: string = ''): boolean => {
    if (email === '') {
        return false;
    }

    if (REGEX_FOR_EMAIL_VALIDATION.test(email)) {
        return false;
    }

    return true;
};
