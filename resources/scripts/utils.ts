/**
 * Formats the given date using `Intl.DateTimeFormat`.
 */
export function formatDate(date: string | Date, options?: Intl.DateTimeFormatOptions) {
	return Intl.DateTimeFormat(undefined, { ...options }).format(date instanceof Date ? date : new Date(date))
}
