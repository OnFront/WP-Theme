import UAParser from "ua-parser-js";
import {currentLanguage} from "../../../resources/js/common/Language";

const APPLE_LINK = 'https://apps.apple.com/pl/app/payeye-2-0/id1628561744';
const GOGGLE_PLAY_LINK = 'https://play.google.com/store/apps/details?id=com.payeye.passwallet';
const APP_GALLERY_LINK = 'https://appgallery.huawei.com/#/app/C106413423';

let ICON_URL = `${window.location.protocol}//${window.location.hostname}/wp-content/themes/payeye2.0/public/icon/store/${currentLanguage()}/`;

const ICON_APP = ICON_URL + 'appstore.svg';
const ICON_GOOGLE = ICON_URL + 'google-play.svg';
const ICON_GALLERY = ICON_URL + 'app-gallery.svg';

export class ApplicationBadge {
    constructor() {
        const ua = new UAParser(window.navigator.userAgent);
        const {vendor} = ua.getDevice();
        const {name} = ua.getOS();

        this.link = '';
        this.icon = '';

        switch (name) {
            case 'iOS':
                this.link = APPLE_LINK;
                this.icon = ICON_APP;
                break;
            case 'Android':
                this.link = GOGGLE_PLAY_LINK;
                this.icon = ICON_GOOGLE;

                if (vendor === 'Huawei') {
                    this.link = APP_GALLERY_LINK;
                    this.icon = ICON_GALLERY;
                }
                break;
        }
    }
}
