export class CardQR {
    constructor (node) {
        this.card = node;
        
        this.toggleCard(this.card);
    }

    toggleCard(item) {
        item.addEventListener('click', () => {
            item.classList.toggle('hide'); 
        })
    }
}