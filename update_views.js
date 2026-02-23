import fs from 'fs';
import path from 'path';

const dir = 'resources/views';
const skipFiles = [
    'resources\\views\\layouts\\app.blade.php',
    'resources/views/layouts/app.blade.php',
    'resources\\views\\dashboard\\index.blade.php',
    'resources/views/dashboard/index.blade.php',
    'resources\\views\\dresses\\index.blade.php',
    'resources/views/dresses/index.blade.php'
];

const replacements = [
    { regex: /bg-rich-mahogany-/g, replacement: 'bg-primary-' },
    { regex: /text-rich-mahogany-/g, replacement: 'text-primary-' },
    { regex: /border-rich-mahogany-/g, replacement: 'border-primary-' },
    { regex: /bg-clay-soil-900/g, replacement: 'bg-gray-900' },
    { regex: /bg-clay-soil-800/g, replacement: 'bg-gray-800' },
    { regex: /text-clay-soil-/g, replacement: 'text-gray-' },
    { regex: /border-clay-soil-/g, replacement: 'border-gray-' },
    { regex: /divide-clay-soil-/g, replacement: 'divide-gray-' },
    { regex: /bg-parchment-100/g, replacement: 'bg-gray-50' },
    { regex: /bg-parchment-/g, replacement: 'bg-gray-' },
    { regex: /text-parchment-/g, replacement: 'text-gray-' },
    { regex: /border-parchment-200/g, replacement: 'border-gray-200' },
    { regex: /border-parchment-300/g, replacement: 'border-gray-300' },
    { regex: /divide-parchment-200/g, replacement: 'divide-gray-200' },
];

function processDir(directory) {
    const files = fs.readdirSync(directory);
    for (const file of files) {
        const fullPath = path.join(directory, file);
        if (fs.statSync(fullPath).isDirectory()) {
            processDir(fullPath);
        } else if (fullPath.endsWith('.blade.php')) {
            if (skipFiles.some(skip => fullPath.includes(skip) || fullPath.endsWith(skip))) {
                console.log(`Skipping: ${fullPath}`);
                continue;
            }

            let content = fs.readFileSync(fullPath, 'utf8');
            let original = content;
            
            // First pass: custom colors
            for (const r of replacements) {
                content = content.replace(r.regex, r.replacement);
            }
            
            // Second pass: hardcoded dark -> light/dark
            content = content.replace(/(?<!dark:|bg-white dark:)bg-gray-900/g, 'bg-white dark:bg-gray-900');
            content = content.replace(/(?<!dark:|bg-gray-50 dark:)bg-gray-800/g, 'bg-gray-50 dark:bg-gray-800');
            content = content.replace(/(?<!dark:|border-gray-200 dark:)border-gray-800/g, 'border-gray-200 dark:border-gray-800');
            content = content.replace(/(?<!dark:|text-gray-600 dark:)text-gray-400/g, 'text-gray-600 dark:text-gray-400');
            content = content.replace(/(?<!dark:|text-gray-900 dark:)text-white/g, 'text-gray-900 dark:text-white');
            content = content.replace(/text-amber-400/g, 'text-primary-600 dark:text-primary-400');
            content = content.replace(/bg-amber-600/g, 'bg-primary-600');
            content = content.replace(/text-gray-300/g, 'text-gray-700 dark:text-gray-300');
            content = content.replace(/bg-gray-950/g, 'bg-gray-50 dark:bg-gray-950');
            
            // Fix double replacements
            content = content.replace(/bg-white dark:bg-white dark:bg-gray-900/g, 'bg-white dark:bg-gray-900');
            content = content.replace(/bg-gray-50 dark:bg-gray-50 dark:bg-gray-800/g, 'bg-gray-50 dark:bg-gray-800');
            content = content.replace(/border-gray-200 dark:border-gray-200 dark:border-gray-800/g, 'border-gray-200 dark:border-gray-800');
            content = content.replace(/text-gray-600 dark:text-gray-600 dark:text-gray-400/g, 'text-gray-600 dark:text-gray-400');
            content = content.replace(/text-gray-900 dark:text-gray-900 dark:text-white/g, 'text-gray-900 dark:text-white');

            if (content !== original) {
                fs.writeFileSync(fullPath, content);
                console.log(`Updated: ${fullPath}`);
            }
        }
    }
}

processDir(dir);
