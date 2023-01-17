const CLASS_ACTIVE = 'tab-active';

export class Tab {
    constructor(node) {
        this.elements = {
            node: node,
            header: node.querySelectorAll('[data-tab-header]'),
            body: node.querySelectorAll('[data-tab-body]'),
        }

        this.event();
    }

    event() {
        this.elements.header.forEach(tab => {
            tab.addEventListener('click', () => {
                this.setActive(tab);
            })
        })
    }

    setActive(tab) {
        const {tabHeader} = tab.dataset;
        this.closeAll();

        tab.classList.add(CLASS_ACTIVE);
        this._getTabBody(tabHeader).classList.add(CLASS_ACTIVE);
    }

    closeAll() {
        this._removeClass(this.elements.header);
        this._removeClass(this.elements.body);
    }

    _getTabBody(tabHeader) {
        return this.elements.node.querySelector(`[data-tab-body="${tabHeader}"]`);
    }

    _removeClass(nodes) {
        nodes.forEach(item => {
            item.classList.remove(CLASS_ACTIVE);
        })
    }
}
