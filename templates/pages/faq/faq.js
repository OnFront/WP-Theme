import {Select} from "../../shared/@select/select";

const CLASS_ACTIVE = 'active';

export class Faq {
    constructor(node) {

        const select = new Select(
            node.querySelector('[name="selectFaq"]'),
            {
                isRemoveFirstElement: true,
                isSearchable: true,
            }
        );

        select.createNodeSelect.addEventListener('searchEvent', () => {
            this._resetTerms();

            const value = select.getSearchInput().value;
            if (!value) {
                this._resetTerms();
                this._resetPosts();
            }
        });

        select.createNodeSelect.addEventListener('selectEvent', () => {
            const option = select.getSelectedOption();
            const {value} = option.dataset;

            this._resetTerms();
            this._resetPosts();
            this._showById(value);
        });


        this.terms = node.querySelectorAll('[data-term-id]');
        this.posts = node.querySelectorAll('[data-faq-term-id]');

        this.terms.forEach((term) => {
            term.addEventListener('click', () => {
                const {termId} = term.dataset;

                if (term.classList.contains(CLASS_ACTIVE)) {
                    this._resetTerms();
                    this._resetPosts();
                } else {
                    this._resetTerms();
                    this._resetPosts();
                    this._showByTermId(termId);
                    term.classList.add(CLASS_ACTIVE);
                }
            });
        })
    }

    _showById(id) {
        this.posts.forEach((post) => {
            const {faqId} = post.dataset;

            let display;

            id === faqId ? display = "block" : display = "none";

            post.style.display = display;
        });
    }

    _showByTermId(termId) {
        this.posts.forEach((post) => {
            const {faqTermId} = post.dataset;

            if (termId !== faqTermId) {
                post.style.display = 'none';
            }

        });
    }

    _resetTerms() {
        this.terms.forEach(term => {
            term.classList.remove(CLASS_ACTIVE);
        })
    }

    _resetPosts() {
        this.posts.forEach(post => {
            post.style.display = 'block';
        })
    }

}
