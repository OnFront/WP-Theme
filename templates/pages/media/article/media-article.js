export class MediaArticle {
    constructor(node) {
        this.node = node;
    }

    hide() {
        this.node.style.display = "none";
    }

    show() {
        this.node.style.display = "";
    }
}
