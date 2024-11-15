import globals from 'globals'
import pluginJs from '@eslint/js'
import js from '@eslint/js'
import pluginVue from 'eslint-plugin-vue'
import vue from 'eslint-plugin-vue'
import vueParser from 'vue-eslint-parser'

const jsRecommendedConfig = js.configs.recommended
const vueRecommendedConfig = vue.configs['vue3-strongly-recommended']

const browserGlobals = {
  window: 'readonly',
  document: 'readonly',
  navigator: 'readonly',
  setTimeout: 'readonly',
  clearTimeout: 'readonly',
  localStorage: 'readonly',
  sessionStorage: 'readonly',
  console: 'readonly',
  event: 'readonly',
  Blob: 'readonly'
}

export default [
  {
    ignores: ['node_modules/**/*', 'dist/**/*']
  },
  {
    files: ['**/*.{js,mjs,cjs,vue}'],
    languageOptions: {
      parser: vueParser,
      parserOptions: {
        ecmaVersion: 2021,
        sourceType: 'module'
      },
      globals: browserGlobals
    },
    plugins: { vue },
    rules: Object.assign({}, jsRecommendedConfig.rules, vueRecommendedConfig.rules, {
      'no-unused-vars': 'error',
      'no-console': 'warn',
      'vue/no-unused-vars': 'error',
      'vue/no-unused-components': 'warn',
      'vue/no-mutating-props': 'error',
      'vue/no-v-html': 'warn',
      'vue/attribute-hyphenation': ['error', 'always'],
      'vue/component-name-in-template-casing': ['error', 'PascalCase'],
      'vue/multiline-html-element-content-newline': [
        'error',
        {
          ignoreWhenEmpty: true,
          ignores: ['pre', 'textarea'],
          allowEmptyLines: false
        }
      ],
      'vue/singleline-html-element-content-newline': 'off',
      'vue/require-default-prop': 'off',
      'vue/html-self-closing': [
        'error',
        {
          html: {
            void: 'always',
            normal: 'always',
            component: 'always'
          },
          svg: 'always',
          math: 'always'
        }
      ],
      semi: [2, 'never']
    })
  },
  {
    languageOptions: {
      globals: globals.browser
    }
  },
  pluginJs.configs.recommended,
  ...pluginVue.configs['flat/essential']
]
