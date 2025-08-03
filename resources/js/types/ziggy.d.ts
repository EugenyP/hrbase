import { RouteParams, Router, KnownRouteName } from 'ziggy-js';

declare global {
    function route(): Router;
    function KnownRouteName(): string;
    function route(name: string, params?: RouteParams<typeof name> | undefined, absolute?: boolean): string;
}

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        route: typeof route;
    }
}
