import { router } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { Ref } from 'vue';

type RData = Record<string, any>;

interface LoadMoreParams {
    nextPageUrl: Ref<string | null>;
    dataList: Ref<RData[]>;
    filterData: Ref<string>;
    entity: string;
    isLoading: Ref<boolean>;
    isSearching: Ref<boolean>;
}

export const formatNumber = (
    num: number,
    local: string = 'en-US',
    options?: Intl.NumberFormatOptions,
) => {
    const defaultOptions: Intl.NumberFormatOptions = {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
        useGrouping: true,
        style: 'currency',
        currency: 'BDT',
        ...options,
    };

    const numberFormatter = new Intl.NumberFormat(local, defaultOptions);
    const parts = numberFormatter.formatToParts(num);
    const value = parts
        .map((p) => {
            if (p.value === 'BDT') {
                return '৳';
            }
            return p.value;
        })
        .join('');

    return value.trim();
};

export const formatDate = (
    value: Date | string | number | null | undefined,
    locale: string = 'en-US',
    options: Intl.DateTimeFormatOptions = { dateStyle: 'medium' },
): string => {
    if (!value) {
        return '';
    }

    const date = new Date(value);

    if (isNaN(date.getTime())) {
        return '';
    }

    const formatter = new Intl.DateTimeFormat(locale, options);

    return formatter.format(date);
};

export const formatData = <T>(
    data: T[],
    formatFn: (item: T) => { value: any; label: string; [key: string]: any },
) => data.map(formatFn);

/**
 * Debounced function to trigger a search on a specific resource.
 *
 * @param {string} resource - The name of the resource to search.
 * @param {string} filterName - The name of the filter to apply.
 * @param {string} value - The value to filter by.
 *
 * @description If a value is provided, reloads the router with the specified resource and filter.
 *              The debouncing is set to 400ms to prevent excessive reloads.
 */
export const search = useDebounceFn(
    (resource: string, filterName: string, value: string) => {
        if (value) {
            router.reload({
                only: [resource],
                data: {
                    filter: {
                        [filterName]: value,
                    },
                },
            });
        }
    },
    500,
);

export const formatAmount = (amount: number) => {
    return new Intl.NumberFormat('en-BD', {
        style: 'currency',
        currency: 'BDT',
        currencyDisplay: 'narrowSymbol',
    }).format(amount ? amount : 0);
};

/**
 * A helper function to load more data from the server based on the provided URL.
 *
 * @param {LoadMoreParams} params - The parameters to use when loading more data.
 *
 * @property {string} nextPageUrl - The URL to use when loading more data.
 * @property {Ref<RData[]>} dataList - The list of data to append to.
 * @property {Ref<string>} filterData - The filter data to pass to the server.
 * @property {string} entity - The name of the entity to load more of.
 * @property {Ref<boolean>} isLoading - A boolean indicating whether the data is currently loading.
 * @property {Ref<boolean>} isSearching - A boolean indicating whether a search is currently happening.
 *
 * @returns {{loadMore: (stopObserver: () => void, intersecting: boolean) => void}} - An object containing the loadMore function.
 */
export const useLoadMoreData = ({
    nextPageUrl,
    dataList,
    filterData,
    entity,
    isLoading,
    isSearching,
}: LoadMoreParams) => {
    /**
     * Loads more data from the server based on the provided URL.
     *
     * @param {() => void} stopObserver - A function to stop observing for changes.
     * @param {boolean} intersecting - A boolean indicating whether the element is currently intersecting with the viewport.
     */
    const loadMore = (stopObserver: () => void, intersecting: boolean) => {
        if (isLoading.value || isSearching.value || !nextPageUrl.value) return;

        isLoading.value = true;

        router.visit(nextPageUrl.value, {
            method: 'get',
            replace: false,
            preserveScroll: true,
            preserveState: true,
            data: { filter: filterData.value },
            onSuccess: (page: Record<string, any>) => {
                const fetchedData = page.props[entity]?.data;
                nextPageUrl.value = page.props[entity]?.next_page_url;

                if (fetchedData) dataList.value.push(...fetchedData);

                isLoading.value = false;
            },
            onError: () => {
                isLoading.value = false;
            },
        });
    };

    return { loadMore };
};

export function getSeverityByStatus(
    status: string,
): 'success' | 'danger' | 'warn' | 'info' | 'secondary' {
    switch (status.toLowerCase()) {
        case 'active':
            return 'success';
        case 'inactive':
            return 'danger';
        case 'on leave':
            return 'warn';
        case 'pending':
            return 'info';
        default:
            return 'secondary';
    }
}
