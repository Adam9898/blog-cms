import {Contains, IsNotEmpty, Length, Max, Min} from "class-validator";
import {Validatable} from "../validation/Validatable";


export class BlogPost implements Validatable{


    @Length(5, 30, {
        message: 'Title length is invalid. Make sure that the number of characters are between 5 and 30'
    })
    title: string;

    content: string;

    constructor(title: string, content: string) {
        this.title = title;
        this.content = content
    }

}
