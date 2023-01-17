const CLASS_CUSTOM_SELECT = 'custom-select';

const CLASS_OPTIONS = CLASS_CUSTOM_SELECT + '__options';
const CLASS_OPTION = CLASS_CUSTOM_SELECT + '__option';
const CLASS_OPTION_EMPTY = CLASS_CUSTOM_SELECT + '__option--empty';
const CLASS_SELECTED = 'selected';
const CLASS_IS_SEARCH = 'search';
const CLASS_IS_OPEN = 'open';

const CLASS_TRIGGER = CLASS_CUSTOM_SELECT + '__trigger';
const CLASS_TRIGGER_PLACEHOLDER = CLASS_TRIGGER + '--placeholder';
const CLASS_TRIGGER_WITH_TRIANGLE = CLASS_TRIGGER + '--with-triangle';

const CLASS_SEARCH_INPUT = CLASS_CUSTOM_SELECT + '__input-search';
const CLASS_ICON_SVG = CLASS_CUSTOM_SELECT + '__icon-svg';
const CLASS_ICON_SVG_WRAPPER = CLASS_CUSTOM_SELECT + '__icon-svg-wrapper';

const CLASS_TAG = CLASS_CUSTOM_SELECT + '__tag';

const ICON_ARROW = '<div class="triangle triangle--down"></div>';
const ICON_SEARCH = `<div class="${CLASS_ICON_SVG_WRAPPER}">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g opacity="0.5"><path d="M15.5 14H14.71L14.43 13.73C15.41 12.59 16 11.11 16 9.5C16 5.91 13.09 3 9.5 3C5.91 3 3 5.91 3 9.5C3 13.09 5.91 16 9.5 16C11.11 16 12.59 15.41 13.73 14.43L14 14.71V15.5L19 20.49L20.49 19L15.5 14ZM9.5 14C7.01 14 5 11.99 5 9.5C5 7.01 7.01 5 9.5 5C11.99 5 14 7.01 14 9.5C14 11.99 11.99 14 9.5 14Z" fill="#272445"/></g>
    </svg>
    </div>`;

class Select {
    constructor(node, settings = null) {
        this.createNodeSelect = null;
        this.node = node;

        this._selectedOption = null;

        this._searchInput = null;

        this._settings = {
            isRemoveFirstElement: false,
            isSearchable: false,
            icon: settings?.isSearchable ? ICON_SEARCH : ICON_ARROW,
            ...settings,
        };

        this._components = {
            customSelect: null,
        }

        this.state = {
            isOpen: false,
        }

        this._init();
    }

    getSelectedOption() {
        return this._selectedOption;
    }

    getSearchInput() {
        return this._searchInput;
    }

    clearSearchInput() {
        this.node.value = '';
        this._searchInput.value = '';
    }

    render() {

        if (this.state.isOpen) {
            this._components.customSelect.classList.add(CLASS_IS_OPEN);
        } else {
            this._components.customSelect.classList.remove(CLASS_IS_OPEN);
        }

    }

    _init() {
        this.node.style.display = 'none';
        this.node.style.pointerEvents = 'none';

        const customWrapper = this._createCustomWrapper();
        this._components.customSelect = this._createCustomSelect();

        const customOptions = this._createCustomOptions();
        const customTrigger = this._createCustomTrigger();

        this._components.customSelect.appendChild(customTrigger);
        this._components.customSelect.appendChild(customOptions);

        customWrapper.append(this._components.customSelect);

        customWrapper.addEventListener('click', () => {
            this.state.isOpen = !this.state.isOpen;
            this.render();
        });

        this.node.after(customWrapper);

        this._selectEvent(customOptions, customWrapper);

        if (this._settings.isSearchable) {
            const emptySearch = this._createEmptySearch();
            emptySearch.style.display = "none";
            customWrapper.querySelector(`.${CLASS_OPTIONS}`).appendChild(emptySearch);
        }

        this.createNodeSelect = customWrapper;

        this._closeSelectOutsideSelect();
        this._searchEvent(customWrapper);
    }

    _selectEvent(customOptions, select) {
        for (const option of customOptions.querySelectorAll(`.${CLASS_OPTION}`)) {

            option.addEventListener('click', () => {
                const {value} = option.dataset;
                const isSelectPlaceholder = value === '';

                if (!option.classList.contains(CLASS_SELECTED)) {
                    const selected = option.parentNode.querySelector(`.${CLASS_OPTION}.${CLASS_SELECTED}`);
                    const input = option.parentNode.parentNode.querySelector(`.${CLASS_TRIGGER} input`);

                    if (selected) {
                        selected.classList.remove(CLASS_SELECTED);
                    }

                    option.classList.add(CLASS_SELECTED);
                    input.value = option.textContent;

                    const triggerPlaceholder = select.querySelector(`.${CLASS_TRIGGER_PLACEHOLDER}`);

                    if (triggerPlaceholder) {
                        triggerPlaceholder.classList.remove(CLASS_TRIGGER_PLACEHOLDER);
                    }

                    this.node.value = option.textContent;

                    if (isSelectPlaceholder) {
                        input.value = '';
                        select.querySelector(`.${CLASS_TRIGGER}`).classList.add(CLASS_TRIGGER_PLACEHOLDER);
                    }

                    this._selectedOption = option;

                    this.createNodeSelect.dispatchEvent(new Event('selectEvent'));
                    this.node.dispatchEvent(new Event('click'));
                }
            })

        }
    }

    _searchEvent(customWrapper) {
        this._searchInput = customWrapper.querySelector(`.${CLASS_SEARCH_INPUT}`);
        const options = customWrapper.querySelectorAll(`.${CLASS_OPTION}`);

        this._searchInput.addEventListener('keyup', () => {
            if (!this.state.isOpen) {
                this.state.isOpen = true;
                this.render();
            }

            const inputValue = this._searchInput.value;
            const filter = inputValue.toUpperCase();
            let isFindSomething = false;

            if (inputValue) {
                customWrapper.querySelector(`.${CLASS_CUSTOM_SELECT}`).classList.add(CLASS_IS_SEARCH);
            } else {
                customWrapper.querySelector(`.${CLASS_CUSTOM_SELECT}`).classList.remove(CLASS_IS_SEARCH);
            }

            options.forEach((option) => {
                const textValue = option.textContent;

                if (textValue.toUpperCase().indexOf(filter) > -1) {
                    option.style.display = '';
                    isFindSomething = true;

                    option.innerHTML = textValue.replace(inputValue, `<span class="${CLASS_TAG}">${inputValue}</span>`);
                } else {
                    option.style.display = 'none';
                }

            });

            if (this._settings.isSearchable) {
                const optionEmpty = customWrapper.querySelector(`.${CLASS_OPTION_EMPTY}`);

                if (isFindSomething) {
                    optionEmpty.style.display = 'none';
                } else {
                    optionEmpty.style.display = 'block';
                }

                this.createNodeSelect.dispatchEvent(new Event('searchEvent'));
            }
        })
    }

    _closeSelectOutsideSelect() {
        window.addEventListener('click', (e) => {
            if (this.state.isOpen && !this.createNodeSelect.parentNode.contains(e.target)) {
                document.querySelectorAll(`.${CLASS_CUSTOM_SELECT}`).forEach(select => {
                    select.classList.remove(CLASS_IS_OPEN);
                })
                this.state.isOpen = false;
            }
        })
    }

    _optionsSelect() {
        return this.node.querySelectorAll('option');
    }

    _createEmptySearch() {
        const emptySearch = document.createElement('div');
        emptySearch.classList.add(CLASS_OPTION);
        emptySearch.classList.add(CLASS_OPTION_EMPTY);
        emptySearch.innerHTML = 'Brak wyników';

        return emptySearch;
    }

    _createCustomOptions() {
        const customOptions = document.createElement('div');
        customOptions.classList.add(CLASS_OPTIONS);

        this._optionsSelect().forEach((option, index) => {

            if (this._settings.isRemoveFirstElement && index === 0) {
                return;
            }

            const dataset = option.dataset;
            const value = option.value;
            const text = option.text;
            const keys = Object.keys(dataset);

            const item = document.createElement('div');
            item.classList.add(CLASS_OPTION);

            if (index === 0) {
                item.classList.add(CLASS_SELECTED);
            }

            item.setAttribute('data-value', value);

            keys.forEach(key => {
                let data = key.replace(/([A-Z])/g, " $1");
                data = data.split(' ').join('-').toLowerCase();

                item.setAttribute(`data-${data}`, dataset[key]);
            })

            item.innerHTML = `${text}`;

            customOptions.appendChild(item);

        });

        return customOptions;
    }

    _createCustomSelect() {
        const customSelect = document.createElement('div');
        customSelect.classList.add(CLASS_CUSTOM_SELECT);

        return customSelect;
    }

    _createCustomTrigger() {
        const trigger = document.createElement('div');

        trigger.classList.add(CLASS_TRIGGER);
        trigger.classList.add(CLASS_TRIGGER_PLACEHOLDER);

        if (!this._settings.isSearchable) {
            trigger.classList.add(CLASS_TRIGGER_WITH_TRIANGLE);
        }

        let disabled;
        this._settings.isSearchable ? disabled = '' : disabled = 'readonly';

        trigger.innerHTML = `<input class="${CLASS_SEARCH_INPUT}" placeholder="${this._optionsSelect()[0].text}" ${disabled}>${this._settings.icon}`;

        return trigger;
    }

    _createCustomWrapper() {
        const wrapper = document.createElement('div');
        wrapper.classList.add(`${CLASS_CUSTOM_SELECT}-wrapper`);

        return wrapper;
    }
}

export {
    Select,
    ICON_ARROW,
    ICON_SEARCH,
}
