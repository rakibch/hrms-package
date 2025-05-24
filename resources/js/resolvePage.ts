export function resolvePage(name: string) {
    // Default app pages
    const appPages = import.meta.glob('./Pages/**/*.vue', { eager: true });

    // Vendor package pages
    const vendorPages = import.meta.glob(
        '../../vendor/softzino/**/resources/js/Pages/**/*.vue',
        { eager: true },
    );

    // Match `namespace::Component/Path`
    if (name.includes('::')) {
        const [namespace, pageName] = name.split('::');
        const prefix = `../../vendor/softzino/${namespace}/resources/js/Pages`;

        const pageKey = Object.keys(vendorPages).find(
            (key) => key.startsWith(prefix) && key.endsWith(`/${pageName}.vue`),
        );

        if (!pageKey || !vendorPages[pageKey]) {
            throw new Error(
                `Page not found in package "${namespace}": ${pageName}`,
            );
        }

        return vendorPages[pageKey];
    }

    // Fallback to app pages
    const pageKey = Object.keys(appPages).find((key) =>
        key.endsWith(`/${name}.vue`),
    );

    if (!pageKey || !appPages[pageKey]) {
        throw new Error(`Page not found in app: ${name}`);
    }

    return appPages[pageKey];
}
