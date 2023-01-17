const CLASS_ACCORDION_OPEN = 'accordion-open';

class Accordion {
    constructor() {
        const accordions = document.querySelectorAll('[data-accordion]');

        accordions.forEach((accordion) => {
            const header = accordion.querySelector('[data-accordion-header]');
            const body = accordion.querySelector('[data-accordion-body]');

            const clientHeight = body.clientHeight;
            body.style.maxHeight = `${0}rem`;

            header.addEventListener('click', (event) => {
                event.preventDefault();

                if (accordion.classList.contains(CLASS_ACCORDION_OPEN)) {
                    body.style.maxHeight = `${0}rem`;
                } else {
                    accordion.classList.remove('close');
                    body.style.maxHeight = `${clientHeight / 10}rem`;
                }

                accordion.classList.toggle(CLASS_ACCORDION_OPEN);
            })
        })
    }
}

export {
    Accordion,
    CLASS_ACCORDION_OPEN,
}

//@TODO Fixed when manual resize from desktop to mobile. Accordion has wrong clientHeight
