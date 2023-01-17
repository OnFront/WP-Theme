export class ScrollTo {
    constructor(node, id, off = 0) {
        this.node = node;
        this.id = id;

        this.node.addEventListener('click', () => {
            $("html, body").animate(
                {
                    scrollTop: $(this.id).offset().top - off,
                },
                800
            );
        });
    }
}
