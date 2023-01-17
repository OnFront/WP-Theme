import Cookies from "js-cookie";
import { currentLanguage, browserLanguage } from "../../../resources/js/common/Language";

const cookieRedirected = 'payeye_cookie_redirected';

export class Front {
    constructor() {
        const isAlreadyRedirected = Cookies.get(cookieRedirected);
        if(!isAlreadyRedirected && currentLanguage() !== 'en' && browserLanguage() === 'en') {
            let expireDay = 1;
            
            Cookies.set(cookieRedirected, 'visited', {expires: expireDay})
            this.redirect('/en');
        }
    }

    redirect(url) {
        const href = document.createElement('a');
        href.href = url;
        href.click();
    }
}