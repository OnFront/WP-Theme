import {MediaApi} from "../../api/admin/MediaApi";

export class MediaPage {
    constructor(node) {
        this.node = node;

        const mediumButton = node.querySelector('.download-medium');

        mediumButton.addEventListener('click', (event) => this.downloadMedium(event));
    }

    downloadMedium(event) {
        event.preventDefault();

        const parent = event.target.parentNode.parentNode.parentNode.parentNode;
        const externalUrl = parent.querySelector('[data-name="externalUrl"] input').value;

        const data = {
            url: externalUrl,
        }

        MediaApi.postMedia(data).then(response => {
            const data = response.data;

            const downloadTitle = data.title;
            const downloadImageUrl = data.imageUrl;

            const postTitle = this.node.querySelector('[name="post_title"]');
            this.node.querySelector('#title-prompt-text').classList.add('screen-reader-text');

            postTitle.value = downloadTitle;

            parent.querySelector('[data-name="downloadImageUrl"] input').value = downloadImageUrl;

            alert('Pobrano medium');
        });
    }
}
