import {Select} from "../../shared/@select/select";
import {MediaArticle} from "./article/media-article";

export class Media {
    constructor(node) {
        const selectedPosts = new MediaArticle(node.querySelector('[data-selected]'));
        const selectMedia = new Select(node.querySelector('[name="selectMedia"]'), {
            isRemoveFirstElement: true, isSearchable: true,
        });
        const selectCategory = new Select(node.querySelector('[name="category"]'));

        selectMedia.createNodeSelect.addEventListener('searchEvent', () => {
            const value = selectMedia.getSearchInput().value;

            if (!value) {
                this._resetPosts();
                selectedPosts.show();
            }

        });

        selectMedia.createNodeSelect.addEventListener('selectEvent', () => {
            const {termId} = selectMedia.getSelectedOption().dataset;

            selectCategory.clearSearchInput();
            this._showPostByTermId(termId);
            selectedPosts.hide();
        });

        this.posts = node.querySelectorAll('[data-posts] [data-parent-term-id]');

        selectCategory.createNodeSelect.addEventListener('selectEvent', () => {
            const {value} = selectCategory.getSelectedOption().dataset;

            this._resetPosts();
            selectedPosts.show();

            if (value) {
                this._showByParentTermId(value);
            }

            selectMedia.clearSearchInput();
        })
    }

    _showByParentTermId(parentTermId) {
        this.posts.forEach(post => {

            if (parentTermId !== post.dataset.parentTermId) {
                post.style.display = 'none';
            }

        });
    }

    _showPostByTermId(id) {
        this.posts.forEach(post => {
            const {termId} = post.dataset;

            let display;

            id === termId ? display = "grid" : display = "none";

            post.style.display = display;
        });
    }

    _resetPosts() {
        this.posts.forEach(post => post.style.display = 'grid');
    }
}
