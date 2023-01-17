import Cookies from "js-cookie";

export const loadClass = (selector, loadClass) => {
    const node = document.querySelectorAll(selector);
    if (node) {
        node.forEach(node => new loadClass(node));
    }
}

export function setCookies(cookieKey, days) {
    let expireDay = days;

    return Cookies.set(cookieKey, true, {expires: expireDay});
}

export function disableScroll() {
    return document.body.classList.add('overflow-hidden');
}

export function enableScroll() {
    return document.body.classList.remove('overflow-hidden');
}

export function elementAddClass(target, className) {
    return target.classList.add(className);
}

export function elementRemoveClass(target, className) {
    return target.classList.remove(className);
}