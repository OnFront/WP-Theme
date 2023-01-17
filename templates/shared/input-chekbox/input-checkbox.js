export class InputCheckbox {
    constructor(node) {
        const label = node.parentNode;
        const title = label.querySelector('[data-js-class-title]');

        const {jsClassName} = label.dataset;
        const {jsClassTitle} = title.dataset;

        node.addEventListener('click', () => {
            label.classList.toggle(jsClassName + '--checked');
            title.classList.toggle(jsClassTitle + '--checked');
        })
    }
}
