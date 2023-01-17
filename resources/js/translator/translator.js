import {currentLanguage} from "../common/Language";

const translator = {
    pl: {
        myLocation: 'Moja lokalizacja',
        moreDetails: 'Więcej szczegółów',
        sale: 'Promocja!',
        navigate: 'Nawiguj',
    },
    en: {
        myLocation: 'My location',
        moreDetails: 'More details',
        sale: 'Sale!',
        navigate: 'Navigate',
    },
}

const trans = translator[currentLanguage()];

export {
    trans,
}

