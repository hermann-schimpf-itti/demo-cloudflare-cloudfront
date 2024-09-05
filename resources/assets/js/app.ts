import './bootstrap';
// @ts-ignore import all images
import.meta.glob([ '../images/**' ]);

import {createSSRApp, DefineComponent, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '@ziggy-js';

createInertiaApp({
    title: (title: string): string => title.length
        ? `${title} - ${import.meta.env.VITE_APP_NAME || 'Laravel'}`
        : import.meta.env.VITE_APP_NAME || 'Laravel',

    resolve: (name: string): Promise<DefineComponent> => {
        const module: string[] = name.split('::');

        if (module.length > 1) {
            return resolvePageComponent(`../../../modules/${module[0]}/resources/vue/${module[1]}.vue`,
                import.meta.glob<DefineComponent>('../../../modules/*/resources/vue/**/*.vue'),
            );
        }

        return resolvePageComponent(`../../vue/${name}.vue`,
            import.meta.glob<DefineComponent>('../../vue/**/*.vue'),
        );
    },

    setup({el, App, props, plugin}): void {
        createSSRApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },

    progress: {
        delay: 250,
        color: '#006496',
    },
});
