const CLASS_ACTIVE = 'tooltip-active';

const ICON_CLOSE = `<svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg"><path d="M9.5 1.40643L8.59357 0.5L5 4.09357L1.40643 0.5L0.5 1.40643L4.09357 5L0.5 8.59357L1.40643 9.5L5 5.90643L8.59357 9.5L9.5 8.59357L5.90643 5L9.5 1.40643Z"/></svg>`;

export class Tooltip {
    constructor(node, settings = {}) {
        this.node = node;

        this.settings = {
            nodeContainer: null,
            ...settings,
        }

        this.state = {
            isActive: false,
        }

        const close = this._createCloseNode();

        this.getTriggerNode().addEventListener('click', () => this.toggleTooltip());
        close.addEventListener('click', () => this.toggleTooltip());

        this.getContextNode().appendChild(close);

        let inside;
        document.body.addEventListener('click', (event) => {
            inside = !!node.contains(event.target);

            if (!inside) {
                this.closeTooltip();
            }

        });

        if (this.settings.nodeContainer) {
            this.settings.nodeContainer.addEventListener('scroll', () => {
                this.closeTooltip();
            })
        }
    }

    getTriggerNode() {
        return this.node.querySelector('[data-trigger]');
    }

    getContextNode() {
        return this.node.querySelector('[data-context]');
    }

    placement() {
        return this.getContextNode().dataset.placement;
    }

    toggleTooltip() {
        this._setPosition();
        this.node.classList.toggle(CLASS_ACTIVE);
        this.state.isActive = !this.state.isActive;
    }

    isActive() {
        return this.node.classList.contains(CLASS_ACTIVE);
    }

    closeTooltip() {
        if (this.state.isActive) {
            this.node.classList.remove(CLASS_ACTIVE);
            this.state.isActive = false;
        }
    }

    _setPosition() {
        let position = this.node.getBoundingClientRect();

        position = {
            top: +window.pageYOffset + position.top + 50,
            left: +position.left,
        }

        this.getContextNode().style.transform = `translate(${position.left}px, ${position.top}px)`;
    }

    _createCloseNode() {
        const close = document.createElement('span');
        close.setAttribute('data-close', '');
        close.innerHTML = ICON_CLOSE;

        return close;
    }
}

export {
    CLASS_ACTIVE,
}
