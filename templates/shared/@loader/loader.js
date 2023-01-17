const CLASS_LOADER = 'loading';
const CLASS_LOADER_ACTIVE = CLASS_LOADER + '--active';
const CLASS_LOADER_GIF = CLASS_LOADER + '__gif';

const ICON = `${window.location.protocol}//${window.location.hostname}/wp-content/themes/payeye/public/icon/layout/loader.gif`;

export class Loader {
    constructor() {
        this.body = document.body;

        this.state = {
            isActive: false,
        }
    }

    show() {
        if (!this.state.isActive) {
            const loader = this._createLoader();
            this.body.appendChild(loader);

            setTimeout(() => {
                this._getLoader().classList.add(CLASS_LOADER_ACTIVE);
                this.state.isActive = true;
            }, 10)
        }
    }

    hide() {
        const loader = this._getLoader();

        if (this.state.isActive && loader) {
            this._getLoader().classList.remove(CLASS_LOADER_ACTIVE);

            setTimeout(() => {
                loader.remove();
                this.state.isActive = false;
            }, 10)
        }
    }

    _createLoader() {
        const loader = document.createElement('div');
        loader.classList.add(CLASS_LOADER);

        const gif = document.createElement('img');
        gif.src = ICON;
        gif.classList.add(CLASS_LOADER_GIF);

        loader.appendChild(gif);

        return loader;
    }

    _getLoader() {
        return document.querySelector(`.${CLASS_LOADER}`);
    }
}
