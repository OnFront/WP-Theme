import {Modal} from "../@modal/modal";

export class ModalVideo {
    constructor(node) {
        this.node = node;
        this.modal = new Modal(node);
    }

    pause() {
        this.node.querySelector('iframe').setAttribute('src', this.node.querySelector('iframe').src);
    }
}
