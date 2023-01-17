import {Select} from "../../shared/@select/select";

export class Promotion {
    constructor(node) {
        this.nodes = {
            selectCategories: node.querySelector('[name="selectCategories"]'),
            search: node.querySelector('[data-js-search]'),
        }

        this.select = new Select(this.nodes.selectCategories);
        this.select.createNodeSelect.addEventListener('selectEvent', () => {
            const {termId} = this.select.getSelectedOption().dataset;

            if (termId) {
                this._showPostByTermId(termId);
            } else {
                this._resetPosts();
            }

        })

        this.posts = node.querySelectorAll('.promotion-card');
        this.nodes.search.addEventListener('keyup', (e) => {
            const value = this.nodes.search.value;
            this._showPostBySearch(value);
        });
    }

    _showPostByTermId(id) {
        this.posts.forEach((post) => {
            const {termId} = post.dataset;

            let display;

            id === termId ? display = "grid" : display = "none";

            post.style.display = display;
        });
    }

    _resetPosts() {
        this.posts.forEach(post => {
            post.style.display = 'grid';
        })
    }

    _showPostBySearch(search) {
        this.select.clearSearchInput();

        this.posts.forEach(post => {
            const textValue = post.textContent;

            if (textValue.toLowerCase().indexOf(search.toLowerCase()) > -1) {
                post.style.display = '';
            } else {
                post.style.display = 'none';
            }
        })
    }
}
