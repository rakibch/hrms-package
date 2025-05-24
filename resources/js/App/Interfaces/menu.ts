export interface Submenu {
    name: string;
    routeName?: string;
}

export interface Menu extends Submenu {
    icon?: any;
    subMenu?: Submenu[];
}
