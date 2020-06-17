import $ from 'jquery';

export class BlogTimeZoneConverter {

    private readonly parsedDate: Date;
    private readonly element: HTMLElement;

    constructor(element: HTMLElement) {
        this.parsedDate = new Date(element.innerText + 'Z');
        this.element = element;
        this.convertTimezone();
    }

    private convertTimezone() {
        const dateString = `${this.parsedDate.getFullYear()}-${this.parsedDate.getMonth() < 10 ? '0'
            + (this.parsedDate.getMonth() + 1) : (this.parsedDate.getMonth() + 1)}-${this.parsedDate.getDate() < 10 ? '0' + this.parsedDate.getDate() : this.parsedDate.getDate()}
        ${this.parsedDate.getHours() < 10 ? '0' + this.parsedDate.getHours() : this.parsedDate.getHours()}:${this.parsedDate.getMinutes() < 10 ? '0' + this.parsedDate.getMinutes() : this.parsedDate.getMinutes()}`;
        this.displayConvertedDate(dateString);
    }

    private displayConvertedDate(dateString: string) {
        $(this.element).text(dateString);
    }

}
