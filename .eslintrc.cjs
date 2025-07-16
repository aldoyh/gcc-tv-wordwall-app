module.exports = {
  env: { browser: true, es2020: true },
  extends: [
    'eslint:recommended',
    // Add any framework-specific configs here, e.g., 'plugin:react/recommended'
    'prettier' // Must be the last one to override other configs
  ],
  parserOptions: { ecmaVersion: 'latest', sourceType: 'module' },
  // Add any framework-specific plugins here, e.g., 'react-refresh'
  plugins: [],
  rules: {},
};