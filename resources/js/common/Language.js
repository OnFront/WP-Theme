const userBrowserLanguage = window.navigator.language;

function currentLanguage() {
    const lang = document.querySelector('html').lang;

    return lang.substring(0, 2);
}

function browserLanguage() {
    return userBrowserLanguage.substring(0,2);
}

export {
    currentLanguage,
    browserLanguage
}

 