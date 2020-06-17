import $ from 'jquery';

export class SenderHelper {

    static displayLoadingAnimation(element: HTMLElement) {
        $(element).html('<img src="../../img/loading.gif">');
    }

    static removeLoadingAnimation() {
        $('.sender-loading-animation').addClass('hide-tag');
    }

}
