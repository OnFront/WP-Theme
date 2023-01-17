const ACTIVE_CLASS = 'team-key__card--active';

export class TeamKey {
    constructor(node) {
        this.isActive = false;
        node.querySelector('[data-js-toggle]').addEventListener('click', () => this.toggle(node));
    }

    toggle(node) {
        this.isActive ? this.removeActive(node) : this.setActive(node);
    }

    setActive(node) {
        node.classList.add(ACTIVE_CLASS);
        this.isActive = true;
    }

    removeActive(node) {
        node.classList.remove(ACTIVE_CLASS);
        this.isActive = false;
    }
}
