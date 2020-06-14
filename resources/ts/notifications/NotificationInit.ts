import $ from 'jquery';
import Echo from 'laravel-echo';
import {NotificationsEchoListener} from "./NotificationsEchoListener";
import {CMSNotification} from "./CMSNotification";
import {Blog} from "../models/Blog";
import io from "socket.io-client";

export class NotificationInit {

    private userId: null | number = null;

    static readonly ECHO = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001',
        client: io
    });

    /**
     * Needed to connect to laravel echo server properly, because the backend uses channel prefix.
     */
    static readonly PRIVATE_REDIS_CHANNEL_PREFIX = 'laravel_database_private-';

    constructor() {
        if (this.userIdExist()) {
            console.log('user id exist');
            this.initializeUserId();
            this.activateEchoChannelListeners();
        }
    }

    private userIdExist() {
        return $('div[data-userid]').length !== 0;
    }

    private initializeUserId() {
        this.userId = $('div[data-userid]').data('userid');
    }

    onNotificationButtonPress() {
        console.log('button pressed');
        const elem = $('#notification-container');
        if (elem.hasClass('hide-tag')) {
            elem.removeClass('hide-tag');
        } else {
            elem.addClass('hide-tag');
        }
    }

    /**
     * Helper method that takes a notification object and adds it to the UI
     */
    static addBlogNotificationToDOM(notification: CMSNotification<Blog>) {
        const notificationTemplate = document.querySelector('#notification-container template') as
            HTMLTemplateElement;
        const notificationNode = notificationTemplate.content.cloneNode(true) as JQuery.Node;
        $(notificationNode + ' .notification-headline').text(`A blog post has been ${notification.type}`);
        $(notificationNode + '.notification-content').text(`The blog post is named <b>${notification.data.title}</b>
        and is written by <b>${notification.data.author}</b>`)
        $('#notification-container').append(notificationNode);
    }


    private activateEchoChannelListeners() {
        if (this.userId != null) {
            new NotificationsEchoListener(this.userId, true);
        }
    }
}
