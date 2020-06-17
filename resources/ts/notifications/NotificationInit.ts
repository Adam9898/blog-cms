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
        const notificationNode = notificationTemplate.content.cloneNode(true);
        $('.notification .notification-headline', notificationNode).html(`A blog post has been <b>${notification.type.toLowerCase()}</b>`);
        $('.notification .notification-content', notificationNode).html(`Blog post title: <b>${notification.data.title}</b><br>
        Blog post author: <b>${notification.data.author}</b>`);
        $('.notification', notificationNode).attr('href', notification.url);
        document.getElementById('notification-container')?.prepend(notificationNode);
        NotificationInit.addOrIncreaseNotificationBadge(1);
    }

    private static addOrIncreaseNotificationBadge(incrementBy: number) {
        const badge = $('.button-badge');
        if (badge.length > 0) {
            badge.text(parseInt(badge.text()) + 1);
        } else {
            $('#notification-icon-container').append(`<span class="button-badge">1</span>`);
        }
    }


    private activateEchoChannelListeners() {
        if (this.userId != null) {
            new NotificationsEchoListener(this.userId, true);
        }
    }
}
