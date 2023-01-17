const postSectionDone = 'business-zone-2-0__pos--done';
const posImageDone = 'business-zone-2-0__pos-image--done';
const posContentDone = 'business-zone-2-0__content--done';

export class BusinessZone20 {
    constructor(node) {
        this.posSection = node.querySelector('[data-js-pos-section]');
        this.posImage = node.querySelector('[data-js-pos]');
        this.content = node.querySelector('[data-js-content]');

        window.addEventListener('scroll', () => this.handeScroll());
    }

    handeScroll() {
        const width = window.innerWidth;

        if (width <= 992) {
            return;
        }

        let top = 14;
        if (window.innerHeight > 960) {
            top = 18;
        }

        const scroll = window.scrollY;

        this.posSection.style.top = `${top}vh`;

        if (scroll > 2400) {
            this.posSection.classList.add(postSectionDone);
            this.posImage.classList.add(posImageDone);
            this.content.classList.add(posContentDone);
        } else {
            this.posSection.classList.remove(postSectionDone);
            this.posImage.classList.remove(posImageDone);
            this.content.classList.remove(posContentDone);
        }
    }
}
