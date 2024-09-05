import fs from 'fs/promises';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import svgLoader from 'vite-svg-loader';

import * as path from 'path';
import {defineConfig} from 'vite';

export default async () => {
    const input = [
        'resources/assets/js/app.ts',
        'resources/assets/css/app.css',
    ];

    for (const module of await fs.readdir('modules/')) {
        if (module.startsWith('.')) continue;

        const folders = [
            `modules/${module}/resources/assets/js`,
            `modules/${module}/resources/assets/css`,
        ];
        for (const folder of folders) {
            try { await fs.access(folder); } catch { continue; }

            const resources = await fs.readdir(`${folder}/`, { recursive: true });
            resources.forEach(asset => {
                if (!asset.startsWith('_') && asset.endsWith('.css') || asset.endsWith('.ts')) {
                    input.push(`${folder}/${asset}`);
                }
            });
        }
    }

    return defineConfig({
        plugins: [
            laravel({
                input,
                ssr: 'resources/assets/js/ssr.ts',
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
            svgLoader(),
        ],

        resolve: {
            alias: {
                '@ziggy-js': path.resolve('vendor/tightenco/ziggy'),

                '~@fortawesome': path.resolve(__dirname, 'node_modules/@fortawesome'),

                '@/assets': path.resolve('resources/assets'),

                '@/Frontend': path.resolve('modules/Frontend/resources/vue'),

                '@': path.resolve('resources/vue'),
                '~': path.resolve('modules'),
            },
        },
    });
};
