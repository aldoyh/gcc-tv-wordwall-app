import en from '../locales/en.json';
import ar from '../locales/ar.json';

const translations: { [key: string]: { [key: string]: string } } = {
  en: en,
  ar: ar,
};

let currentLang = 'en';

export function setLanguage(lang: string) {
  if (typeof window !== 'undefined') {
    currentLang = lang;
    localStorage.setItem('lang', lang);
    document.documentElement.lang = lang;
    if (lang === 'ar') {
      document.documentElement.dir = 'rtl';
    } else {
      document.documentElement.dir = 'ltr';
    }
  }
}

export function getLanguage() {
  if (typeof window !== 'undefined') {
    const storedLang = localStorage.getItem('lang');
    if (storedLang) {
      currentLang = storedLang;
    }
  }
  return currentLang;
}

export function t(key: string, ...args: (string | number)[]): string {
  const lang = getLanguage();
  let translation = translations[lang][key] || translations.en[key] || key;

  args.forEach((arg, index) => {
    translation = translation.replace(`{${index}}`, String(arg));
  });

  return translation;
}