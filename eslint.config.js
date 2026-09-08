import js from '@eslint/js';
import globals from 'globals';
import vue from 'eslint-plugin-vue';
import tseslint from 'typescript-eslint';
import vueParser from 'vue-eslint-parser';
import tsParser from '@typescript-eslint/parser';

export default [
    js.configs.recommended,
    ...vue.configs['flat/essential'],
    ...tseslint.configs.recommended,
    {
        files: ['resources/js/**/*.{js,mjs,cjs,ts,vue}'],

        languageOptions: {
            parser: vueParser,
            globals: globals.node,

            parserOptions: {
                parser: tsParser
            }
        },

        rules: {
            'no-undef': 'off',
            'vue/multi-word-component-names': 'off',
            'vue/no-undef-components': ['error', { ignorePatterns: ['RouterLink', 'RouterView'] }],
            'no-restricted-imports': ['error', { patterns: ['../../*', '*.ts'] }],
            '@typescript-eslint/no-unused-vars': [
                'error',
                {
                    varsIgnorePattern: '^_',
                    argsIgnorePattern: '^_',
                    caughtErrorsIgnorePattern: '^_',
                    destructuredArrayIgnorePattern: '^_'
                }
            ]
        }
    }
];
