import {Select} from "../../shared/@select/select";
import {SimpleCustomInputFile} from "../../../resources/js/bootstrap/SimpleCustomInputFile";
import {CLASS_ACCORDION_OPEN} from "../../../resources/js/bootstrap/Accordion";

export class Contact {
    constructor(node) {
        const file = node.querySelector('[name="file-1"]');

        new Select(node.querySelector('[name="subject"]'), {
            isRemoveFirstElement: true,
        });

        if (file) {
            new SimpleCustomInputFile(file);
        }

        const accordions = node.querySelectorAll('[data-accordion="checkbox"]');
        accordions.forEach(accordion => {
            const header = accordion.querySelector('[data-accordion-header]');

            header.addEventListener('click', () => {
                const {stringOpen, stringClose} = header.dataset;

                const hasClass = accordion.classList.contains(CLASS_ACCORDION_OPEN);

                if (hasClass) {
                    header.innerHTML = stringOpen;
                } else {
                    header.innerHTML = stringClose;
                }

            })
        })
    }
}
