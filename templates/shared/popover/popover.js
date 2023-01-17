export class Popover {
    constructor(node) {
        const {jsPopover} = node.dataset;

        const component = document.querySelector(`[data-js-popover-id="${jsPopover}"]`);

        node.addEventListener('click', () => component.classList.toggle('active'));
    }
}
