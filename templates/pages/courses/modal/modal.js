import { ctaButtons } from "../courses";
import { disableScroll, enableScroll, elementAddClass, elementRemoveClass } from "../../../../resources/js/common/functions";

export class ModalCourse {
    constructor(node) {
        this.modal = node;
        this.iframe = node.querySelector('.course-modal__iframe');
        this.close = node.querySelector('.course-modal__close');
     
        this.openModal(ctaButtons);
        this.closeModal(this.close);
    }

    openModal(buttons) {
        const modal = this.modal;
        const iframe = this.iframe;

        if(buttons.length < 1) {
            return void(0);
        }

        buttons.forEach( btn => {
            const btnLink = btn.getAttribute('data-js-link');

            btn.addEventListener('click', (e) => {
                e.preventDefault();
                
                disableScroll();
                this.passLinkToVideo(iframe, btnLink);
                elementAddClass(modal, 'opened');
            })
        })
    }

    closeModal(button) {
        const modal = this.modal;
        const iframe = this.iframe;

        button.addEventListener('click', () => {
            enableScroll();
            elementRemoveClass(modal, 'opened');
            this.pauseVideo(iframe);
        })
    }

    passLinkToVideo(iframe, link) {
        iframe.src = link;
    }

    pauseVideo(iframe) {
        iframe.src = '';
    }
}