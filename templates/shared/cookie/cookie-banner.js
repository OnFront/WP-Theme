import "js-cookie";
import {CookiePreference} from "./cookie-preference";
import {Modal} from "../@modal/modal";

const COOKIE_NAME = 'cookie-modal';
const COOKIE_VALUE = 'true';
const COOKIE_EXPIRES_DAYS = 30;

export const ACTIVE_ANALYTICS_NAME = 'active-analytics';
const ACTIVE_ANALYTICS_VALUE = 'true';

const ACTIVE_ADS_NAME = 'active-ads';
const ACTIVE_ADS_VALUE = 'true';

export class CookieBanner {
    constructor(node) {
        this.node = node;

        this.nodeBtnAccept = node.querySelector('[data-btn-accept]');
        this.nodeBtnPreference = node.querySelector('[data-btn-preference]');
        this.nodeBtnReject = node.querySelector('[data-btn-reject]');

        if (this.isAccept()) {
            this.node.remove();
        } else {
            this.render();
        }
    }

    render() {
        this.node.style.display = "block";

        this.nodeBtnAccept.addEventListener('click', () => {
            this.enableAnalytics();
            this.enableAds();
            this.disableBanner();
        });

        this.nodeBtnReject.addEventListener('click', () => {
            this.disableBanner();
        })

        const nodeModal = document.querySelector('[data-js-cookie-modal]');

        const modal = new Modal(nodeModal, {
            isOutsideHide: false,
        });
        const cookiePreference = new CookiePreference(nodeModal);

        this.nodeBtnPreference.addEventListener('click', () => {
            modal.show();
        });

        modal.node.addEventListener('modalHide', () => {
            if (cookiePreference.state.analytics) {
                this.enableAnalytics();
            }

            if (cookiePreference.state.ads) {
                this.enableAds();
            }

            this.disableBanner();
        })
    }

    isAccept() {
        return Cookies.get(COOKIE_NAME) === COOKIE_VALUE;
    }

    disableBanner() {
        this.setCookie(COOKIE_NAME, COOKIE_VALUE);
        this.node.remove();
    }

    enableAnalytics() {
        this.setCookie(ACTIVE_ANALYTICS_NAME, ACTIVE_ANALYTICS_VALUE);
    }

    enableAds() {
        this.setCookie(ACTIVE_ADS_NAME, ACTIVE_ADS_VALUE);
    }

    setCookie(name, value) {
        Cookies.set(name, value, {
            expires: COOKIE_EXPIRES_DAYS,
        })
    }
}
