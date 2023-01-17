export class Countdown {
    constructor(node) {
        this.node = node;

        const second = 1000,
            minute = second * 60,
            hour = minute * 60,
            day = hour * 24;

        const countDown = new Date(2022, 5, 24, 0, 1).getTime();

        const startCount = setInterval(() => {
            const now = new Date().getTime();
            const distance = countDown - now;

            const date = {
                day: Math.floor(distance / (day)),
                hour: Math.floor((distance % (day)) / (hour)),
                minute: Math.floor((distance % (hour)) / (minute)),
                second: Math.floor((distance % (minute)) / second),
            }

            const dateRender = {
                day: {
                    first: this.getFirst(date.day),
                    second: this.getSecond(date.day),
                },
                hour: {
                    first: this.getFirst(date.hour),
                    second: this.getSecond(date.hour),
                },
                minute: {
                    first: this.getFirst(date.minute),
                    second: this.getSecond(date.minute),
                },
                second: {
                    first: this.getFirst(date.second),
                    second: this.getSecond(date.second),
                },
            }

            this.render(dateRender);

            if (distance < 0) {
                clearInterval(startCount);
            }
        }, 1000)
    }

    render(date) {
        this.node.querySelector('[data-js-day="1"]').innerHTML = date.day.first;
        this.node.querySelector('[data-js-day="2"]').innerHTML = date.day.second;

        this.node.querySelector('[data-js-hour="1"]').innerHTML = date.hour.first;
        this.node.querySelector('[data-js-hour="2"]').innerHTML = date.hour.second;

        this.node.querySelector('[data-js-minute="1"]').innerHTML = date.minute.first;
        this.node.querySelector('[data-js-minute="2"]').innerHTML = date.minute.second;

        this.node.querySelector('[data-js-second="1"]').innerHTML = date.second.first;
        this.node.querySelector('[data-js-second="2"]').innerHTML = date.second.second;
    }

    getFirst(number) {
        if (number < 10) {
            return 0;
        }

        return number.toString().charAt(0);
    }

    getSecond(number) {
        if (number > 9) {
            return number.toString().charAt(1);
        }

        return number;
    }
}
