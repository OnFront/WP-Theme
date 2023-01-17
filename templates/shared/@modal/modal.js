const CLASS_NAME_OPEN = 'modal-open'
const CLASS_NAME_BACKDROP = 'modal-backdrop';
const CLASS_NAME_FADE = 'fade';
const CLASS_NAME_SHOW = 'show';

const ESCAPE_KEY = 'Escape'

export class Modal {
    constructor(node, settings = null) {
        this.node = node;

        this._settings = {
            isOutsideHide: true,
            ...settings,
        }

        this._backdrop = null;
        this._isBodyOverflowing = false;

        this.state = {
            open: false,
        }

        const closeButton = this.node.querySelector('[data-js-close-modal]');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                this.state.open = false;
                this.hide();
            });
        }

        window.addEventListener('keydown', (e) => {
            if (this.state.open && e.key === ESCAPE_KEY) {
                this.state.open = false;
                this.hide();
            }
        });

        if (this._settings.isOutsideHide) {
            window.addEventListener('click', (e) => {

                if (this.state.open && e.target.contains(this.node)) {
                    this.state.open = false;
                    this.hide();
                }
            })
        }

    }

    show() {
        this.state.open = true;

        if (this.state.open) {
            this._checkScrollbar();

            this._showBackDrop();
            this._showModal();
        }

        this.node.dispatchEvent(new Event('modalOpen'));
    }

    hide() {
        this.node.classList.remove(CLASS_NAME_SHOW);
        this._backdrop.classList.remove(CLASS_NAME_SHOW);

        this._removeBackdrop();
        this.state.open = false;

        this.node.dispatchEvent(new Event('modalHide'));
    }

    _removeBackdrop() {
        if (this._backdrop) {
            setTimeout(() => {
                this._checkScrollbar();
                document.body.classList.remove(CLASS_NAME_OPEN);

                this.node.style.display = 'none';

                this._backdrop.remove();
                this._backdrop = null;

            }, 500);
        }
    }

    _showModal() {
        document.body.classList.add(CLASS_NAME_OPEN);
        this.node.style.display = 'block';

        this._animateAdd(this.node, CLASS_NAME_SHOW);
    }

    _showBackDrop() {
        this._backdrop = document.createElement('div');

        this._backdrop.classList.add(CLASS_NAME_BACKDROP);
        this._backdrop.classList.add(CLASS_NAME_FADE);

        document.body.appendChild(this._backdrop);

        this._animateAdd(this._backdrop, CLASS_NAME_SHOW);
    }

    _checkScrollbar() {
        const rect = document.body.getBoundingClientRect();
        this._isBodyOverflowing = Math.round(rect.left + rect.right) < window.innerWidth;

        const scrollbar = window.innerWidth - rect.width;

        document.body.style.paddingRight = scrollbar + 'px';

        const mainHeader = document.querySelector('#main-header');

        if (mainHeader) {
            mainHeader.style.paddingRight = scrollbar + 'px';
        }
    }

    _animateAdd(element, className) {

        setTimeout(() => {
            element.classList.add(className);
        }, 50);

    }
}
