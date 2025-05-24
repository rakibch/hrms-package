/**
 * Formats an ISO 8601 date string to a custom format: "MMM DD, YYYY".
 *
 * @param isoDateString - The ISO 8601 date string to format (e.g., "2025-01-14T09:23:21.000000Z").
 * @returns The formatted date string (e.g., "Jan 14, 2025").
 */
export function formatIsoDateToReadable(isoDateString: string): string {
    return new Date(isoDateString).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    });
}
