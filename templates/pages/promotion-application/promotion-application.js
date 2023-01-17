export class PromotionApplication {
    constructor(node) {
        const link = document.createElement('a');

        const currentLang = document.documentElement.lang.substring(0, 2);
        const lang = navigator.language.substring(0, 2);

        if (currentLang === 'pl' && lang === 'en') {
            link.href = 'https://payeye.com/en/promotions-application/';
            link.click();
        }

        if (currentLang === 'en' && lang === 'pl') {
            link.href = 'https://payeye.com/promocje-aplikacja/';
            link.click();
        }
    }
}
