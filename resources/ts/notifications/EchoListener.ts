/**
 * EchoListener is an abstract class that works as an interface for specific Laravel Echo event and notification
 * listeners, expect that the constructor is explicitly defined. The constructor lets the consumer of the class
 * decide if it wants to explicitly activate the listener, or on object creation.
 */
export abstract class EchoListener {


    protected constructor(activateListener = false, protected userId?: number) {
        if (activateListener) {
            this.activateListener();
        }
    }

    abstract activateListener(): void;
    protected abstract listenerCallback(payload: any): void;
}
