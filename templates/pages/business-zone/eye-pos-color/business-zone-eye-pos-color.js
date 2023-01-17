const pictureActive = 'business-zone-eye-pos-color__picture--active';
const buttonActive = 'business-zone-eye-pos-color__button--active';

export class BusinessZoneEyePosColor {
    constructor(node) {
        this.node = node;
        this.pictures = node.querySelectorAll('[data-js-color]');
        this.buttons = node.querySelectorAll('[data-js-color-id]');

        this.buttons.forEach(button => button.addEventListener('click', evt => this.handleButton(evt)));
    }

    handleButton(event) {
        const {jsColorId} = event.target.dataset;
        this.removeActivatedButtons();

        event.target.classList.add(buttonActive);

        this.changePicture(jsColorId);
    }

    changePicture(color) {
        this.removeActivatedPicture();
        this.node.querySelector(`[data-js-color="${color}"]`).classList.add(pictureActive);
    }

    removeActivatedPicture() {
        this.pictures.forEach(picture => picture.classList.remove(pictureActive));
    }

    removeActivatedButtons() {
        this.buttons.forEach(picture => picture.classList.remove(buttonActive));
    }
}
