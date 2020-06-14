import {EchoListener} from "./EchoListener";
import {NotificationInit} from "./NotificationInit";
import {CMSNotification} from "./CMSNotification";
import {Blog} from "../models/Blog";

export class NotificationsEchoListener extends EchoListener {

    constructor(currentUserID: number, activateListener = false) {
        super(activateListener, currentUserID);
    }


    activateListener(): void {
        NotificationInit.ECHO.channel(`${NotificationInit.PRIVATE_REDIS_CHANNEL_PREFIX}App.User.${this.userId}`)
            .notification(this.listenerCallback);
    }

    protected listenerCallback(notificationPayload: any): void {
        const notificationObj: CMSNotification<Blog> = {
            data: new Blog(notificationPayload.blogAuthor, notificationPayload.blogTitle),
            url: window.location.host + notificationPayload.url,
            type: notificationPayload.type.substr(-1, notificationPayload.type.indexOf('\\'))
        }
        NotificationInit.addBlogNotificationToDOM(notificationObj);
    }


}
