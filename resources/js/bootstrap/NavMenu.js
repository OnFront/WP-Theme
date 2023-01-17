export class NavMenu {
    constructor() {
        this.state = {
            open: false,
        }

        this.component = {
            mainHeader: document.querySelector('[data-js-navigation]'),
            hamburgers: document.querySelectorAll('.hamburger'),
            nav: document.querySelector('[data-js-navigation-mobile]'),
        }

        this.event();
    }

    event() {
        let countClick = 0;

        this.component.hamburgers.forEach((hamburger, index, hamburgers) => {
            hamburger.addEventListener('click', () => {

                hamburgers.forEach(hamburger => {
                    hamburger.classList.toggle('active');
                })

                this.component.nav.classList.toggle('active');
                this.component.mainHeader.classList.add('scroll-top');
                document.body.classList.add('stop-scroll');

                countClick++;
                this.state.open = true;
                if (countClick === 2) {
                    this.closeAll();
                    this.state.open = false;
                    countClick = 0;
                }

            });
        })
    }

    closeAll() {
        this.component.nav.classList.remove('active');
        this.component.hamburgers.forEach((hamburger) => hamburger.classList.remove('active'));
        this.component.mainHeader.classList.remove('scroll-top');
        document.body.classList.remove('stop-scroll');
    }
}
