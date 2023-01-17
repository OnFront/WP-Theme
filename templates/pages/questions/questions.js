import {Select} from "../../shared/@select/select";
import {QuestionApi} from "../../../resources/js/api/front/QuestionApi";
import {CLASS_ACCORDION_OPEN} from "../../../resources/js/bootstrap/Accordion";
import {ACTIVE_ANALYTICS_NAME} from "../../shared/cookie/cookie-banner";

const classCardBtnInCookie = 'question-page__card-btn--in-cookie';
const classCardNumberActive = 'question-page__card-btn-number--active';
const classCardCountInCookie = 'question-page__card-number--in-cookie';

export class Questions {
    constructor(node) {
        this.buttons = node.querySelectorAll('[data-post-id]');
        this.sort = node.querySelector('[data-js-sort]');
        this.body = node.querySelector('[data-js-body]');
        this.cards = node.querySelectorAll('[data-js-like]');
        this.seeMore = node.querySelector('[data-js-more]');

        const cards = [];
        this.cards.forEach(card => {
            cards.push(card);
        })

        this.state = {
            cards: cards,
            count: 9,
            isMore: true,
            pagePer: 9,
        }

        new Select(this.sort);

        const search = new Select(
            node.querySelector('[data-js-search]'),
            {
                isRemoveFirstElement: true,
                isSearchable: true,
            }
        )

        search.createNodeSelect.addEventListener('searchEvent', () => {
            const value = search.getSearchInput().value;
            if (!value) {
                this.render();
            }
        })

        search.createNodeSelect.addEventListener('selectEvent', () => {
            const option = search.getSelectedOption();
            const {value} = option.dataset;


            this._showById(value);
        })

        this.events();

        const accordions = node.querySelectorAll('[data-accordion="checkbox"]');
        accordions.forEach(accordion => {
            const header = accordion.querySelector('[data-accordion-header]');

            header.addEventListener('click', () => {
                const {stringOpen, stringClose} = header.dataset;

                const hasClass = accordion.classList.contains(CLASS_ACCORDION_OPEN);

                if (hasClass) {
                    header.innerHTML = stringOpen;
                } else {
                    header.innerHTML = stringClose;
                }

            })
        })
    }

    events() {
        let cookieQuestions = Cookies.get('questions') ?? [];
        if (cookieQuestions && !(cookieQuestions instanceof Array)) {
            cookieQuestions = JSON.parse(cookieQuestions);
        }

        this.buttons.forEach(button => {
            const {postId} = button.dataset;
            const countNode = button.parentNode.querySelector('[data-js-count]');

            if (cookieQuestions.includes(postId)) {
                button.classList.add(classCardBtnInCookie);
                countNode.classList.add(classCardCountInCookie);
            } else {
                button.addEventListener('click', () => {
                    const data = {
                        postId,
                    }

                    cookieQuestions.push(postId);
                    const number = button.querySelector('[data-js-number]');

                    button.disabled = true;
                    button.classList.add(classCardBtnInCookie);
                    number.classList.add(classCardNumberActive);
                    countNode.classList.add(classCardCountInCookie);

                    QuestionApi.like(data).then(response => {
                        const {count} = response.data;
                        countNode.innerHTML = count;

                        if (Cookies.get(ACTIVE_ANALYTICS_NAME)) {
                            Cookies.set('questions', JSON.stringify(cookieQuestions));
                        }
                    })

                    setTimeout(() => {
                        number.classList.remove(classCardNumberActive);
                    }, 1000);

                })
            }
        })

        this.sort.addEventListener('click', () => {
            this.state.cards.reverse();
            this.render();
        });

        this.seeMore.addEventListener('click', (event) => {
            event.preventDefault();

            this.state.count += this.state.pagePer;
            this.state.isMore = this.cards.length >= this.state.count

            this.render();
        })
    }

    render() {
        this.body.innerHTML = '';

        this.state.cards.forEach((card, index) => {
            card.style.display = 'flex';

            if (index >= this.state.count) {
                card.style.display = 'none';
            }

            this.body.appendChild(card);
        })

        if (!this.state.isMore) {
            this.seeMore.style.display = "none";
        }
    }

    _showById(postId) {
        this.cards.forEach(post => {
            const {id} = post.dataset;
            post.style.display = postId === id ? "flex" : "none";
        });
    }
}
