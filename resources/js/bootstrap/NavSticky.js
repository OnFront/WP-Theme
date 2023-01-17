const CLASS_SCROLL_IS_MOVE = 'scroll-is-move';

export class NavSticky {
    constructor(selector, NavMenu) {
        this.header = document.querySelector(selector);


        this.navMenu = NavMenu;
        this.settings = {
            offset: 500,
            offsetWhenScrollIsMove: 52,
        };

        this.state = {
            isWhiteHeader: document.body.classList.contains('page-template-ListPartnersController'),
        }

        if (window.innerWidth < 1200) {
            this.settings.offsetWhenScrollIsMove = 1;

            if (this.state.isWhiteHeader) {
                this.settings.offsetWhenScrollIsMove = -1;

                this.header.classList.add(CLASS_SCROLL_IS_MOVE);
            }
        }

        this.lastScroll = 0;

        window.onscroll = () => {
            const scrollY = window.scrollY;
            this.onScroll(scrollY);
        };
    }

    onScroll() {
        const isScrollBottom = scrollY > this.lastScroll;
        this.navMenu.closeAll();

        if (scrollY > this.settings.offsetWhenScrollIsMove) {
            this.addIfNotExist(CLASS_SCROLL_IS_MOVE);
        } else {
            this.removeIfExist(CLASS_SCROLL_IS_MOVE);
        }

        if (!isScrollBottom) {
            this.removeIfExist('scroll-hide');
            this.addIfNotExist('scroll-top');
        } else {
            this.addIfNotExist('scroll-hide');
            this.removeIfExist('scroll-top');
        }

        if (scrollY < this.settings.offset) {
            this.removeIfExist('scroll-top');
            this.removeIfExist('scroll-hide');
        }

        this.lastScroll = scrollY;
    }

    addIfNotExist(className) {
        !this.header.classList.contains(className) ? this.header.classList.add(className) : null;
    }

    removeIfExist(className) {
        this.header.classList.contains(className) ? this.header.classList.remove(className) : null;
    }
}
