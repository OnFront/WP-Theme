const CLASS_ACTIVE = 'marker-active';

export class ListPartners {
    constructor(node) {
        this.node = node;
        this.posts = node.querySelectorAll('[data-partner-id]');
        this.noFound = node.querySelector('[data-no-result]');

        this.state = {
            isFindSomething: true,
        }
    }

    setActive(partnerId) {
        this.posts.forEach((post) => {
            const {partnerId: postPartnerId} = post.dataset;

            post.classList.remove(CLASS_ACTIVE);

            if (partnerId === postPartnerId) {
                post.classList.add(CLASS_ACTIVE);
            }
        })
    }

    showPostsByTermsAndIsPromo(terms, isActivePromo) {
        const isTerms = !!terms.length;

        this.posts.forEach(post => {
            let {termId, isPromo} = post.dataset;


            this.hide(post);

            if (!isTerms) {
                this.show(post);
            } else if (isTerms && terms.includes(termId)) {
                this.show(post);
            }

        })

    }

    showPostsByContainsTitle(search) {
        this.state.isFindSomething = false;

        this.posts.forEach(post => {

            if (post.style.display === 'none') {
                return;
            }

            const title = post.querySelector('[data-js-merchant-title]').innerText;

            if (title.toLowerCase().includes(search.toLowerCase())) {
                this.show(post);
                this.state.isFindSomething = true;
            } else {
                this.hide(post);
            }
        })
    }

    hide(postNode) {
        postNode.style.display = "none";
    }

    show(postNode) {
        postNode.style.display = "";
    }

    showNotFound() {
        this.show(this.noFound);
    }

    hideNotFound() {
        this.hide(this.noFound);
    }
}
