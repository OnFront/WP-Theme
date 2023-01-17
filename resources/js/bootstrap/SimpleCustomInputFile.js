const CLASS_CUSTOM_INPUT_FILE = 'custom-input-file';

const CLASS_ACCEPT_FILES = CLASS_CUSTOM_INPUT_FILE + '__accept-files';
const CLASS_CHOSE_FILE = CLASS_CUSTOM_INPUT_FILE + '__chose-file';

const SVG = '<svg width="11" height="22" viewBox="0 0 11 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.5 5V16.5C9.5 18.71 7.71 20.5 5.5 20.5C3.29 20.5 1.5 18.71 1.5 16.5V4C1.5 2.62 2.62 1.5 4 1.5C5.38 1.5 6.5 2.62 6.5 4V14.5C6.5 15.05 6.05 15.5 5.5 15.5C4.95 15.5 4.5 15.05 4.5 14.5V5H3V14.5C3 15.88 4.12 17 5.5 17C6.88 17 8 15.88 8 14.5V4C8 1.79 6.21 0 4 0C1.79 0 0 1.79 0 4V16.5C0 19.54 2.46 22 5.5 22C8.54 22 11 19.54 11 16.5V5H9.5Z" fill="#272445"/></svg>';

const CLASS_TRIGGER = CLASS_CUSTOM_INPUT_FILE + '__trigger';

export class SimpleCustomInputFile {
    constructor(nodeInput) {
        this._nodeInput = nodeInput;
        this._nodeInput.style.display = 'none';

        this._wrapper = this._createWrapper();

        const acceptFiles = this._createAcceptFiles();
        const choseFile = this._createChoseFile();

        this._wrapper.appendChild(acceptFiles);
        this._wrapper.appendChild(choseFile);

        this._nodeInput.after(this._wrapper);

        this._nodeInput.addEventListener('change', (e) => {
            const files = e.target.files;

            const name = files[0]?.name ?? '';

            this._setChoseFile(name);

        })
    }

    _setChoseFile(name) {
        this._wrapper.querySelector(`.${CLASS_CHOSE_FILE}`).innerHTML = name;
    }

    _createChoseFile() {
        const chose = document.createElement('div');
        chose.classList.add(CLASS_CHOSE_FILE);

        return chose;
    }

    _createAcceptFiles() {
        const stringTranslate = document.querySelector('#translate-add-file').value;

        let files = SVG + `<span class="${CLASS_TRIGGER}">${stringTranslate}</span>`;

        files += `(${this._nodeInput.accept.replaceAll('.', '')})`;
        files = files.replaceAll(',', ', ');

        const acceptFiles = document.createElement('div');

        acceptFiles.classList.add(CLASS_ACCEPT_FILES);
        acceptFiles.innerHTML = files;

        return acceptFiles;
    }

    _createWrapper() {
        const wrapper = document.createElement('div');

        wrapper.classList.add(CLASS_CUSTOM_INPUT_FILE);


        return wrapper;
    }
}
