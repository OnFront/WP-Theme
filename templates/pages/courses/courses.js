const ctaButtons = document.querySelectorAll('[data-js-link]');

export { ctaButtons }

export class Courses {
    constructor(node) {    
        this.searchBarInput = node.querySelector('[data-js-searchbar]');
        this.optionsTitle = node.querySelectorAll('[data-js-custom-options-item]');
        this.searchBarOptions = node.querySelector('[data-js-custom-options]');
        this.searchBarTrigger = node.querySelector('[data-js-search-trigger]');
        this.articles = node.querySelectorAll('[data-js-courses-list-item]');

        this.searchEvents(this.searchBarTrigger, this.searchBarInput );
        this.selectOption(this.optionsTitle);
    }


    searchEvents(trigger, input) {

        const optionsTitle = this.optionsTitle;
        const searchBarOptions = this.searchBarOptions;
        const articles = this.articles;
        
        if(!trigger && !input) {
            return void(0);
        }

        trigger.addEventListener('click', () => {
            this.toggleOptionsList(searchBarOptions);
        })

        input.addEventListener('keyup', () => {
            this.openOptionsList(searchBarOptions);
        })

        input.addEventListener('input', () => {

            input.value === '' ? this.displayAllArticles(articles) : '';

            if(optionsTitle < 1) {
                return void(0);
            }
        
            this.highlightLetters(optionsTitle, input);
            this.filterOptions(optionsTitle, input);
        })
    }

    openOptionsList(list) {
        list.classList.add('active');
    }

    toggleOptionsList(list) {
        list.classList.toggle('active');
    }

    filterOptions(options, input) {
      
        options.forEach(option => {
            const string = option.innerText || option.textContent;
            const filter = input.value.toUpperCase();

            string.toUpperCase().indexOf(filter) > -1 ? this.showOption(option) : this.hideOption(option) ;
        })
    }

    selectOption(options) {

        options.forEach(option => {
            const optionId = option.getAttribute('id');
            const optionVal = option.innerText || option.textContent;
            const input = this.searchBarInput;

            option.addEventListener('click', () => {
                input.value = optionVal;
                this.sortArticles(optionId);
            })
        })
    }

    showOption(option) {
        option.style.display = 'block';
    }

    hideOption(option) {
        option.style.display = 'none';
    }

    sortArticles(id) {
        const articles = this.articles;

        if(articles.length < 1) {
            return void(0);
        }

        articles.forEach(article => {
            const articleId = article.getAttribute('id');
        
            id === articleId ? article.style.display = '' : article.style.display = 'none';
        })
    }

    displayAllArticles(articles) {
       articles.forEach(article => { article.style.display = 'grid' });
    }

    highlightLetters(options, input) {
        const value = input.value;
        const filter = input.value.toUpperCase();
      
        options.forEach(option => {
            let string = option.textContent || option.innerText;

            if (string.toUpperCase().indexOf(filter) > -1) {
                this.showOption(option);
                option.innerHTML = string.replace(value, `<span class="highlight">${value}</span>`);
            } else {
                this.hideOption(option);
            }
        })
    }
}