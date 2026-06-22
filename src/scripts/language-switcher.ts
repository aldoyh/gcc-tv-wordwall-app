import { setLanguage } from '../utils/i18n';

const languageSelect = document.getElementById('language-select') as HTMLSelectElement;
if (languageSelect) {
  languageSelect.value = localStorage.getItem('lang') || 'en';
  languageSelect.addEventListener('change', (e) => {
    setLanguage((e.target as HTMLSelectElement).value);
    location.reload();
  });
}
