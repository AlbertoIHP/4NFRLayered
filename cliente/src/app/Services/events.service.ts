import { Injectable, EventEmitter } from '@angular/core'

@Injectable()
export class EventService {
    public isSingIn: any
    public isSingOut: any
    public isSingUp: any


    constructor() {
        this.isSingIn = new EventEmitter()
        this.isSingOut = new EventEmitter()
        this.isSingUp = new EventEmitter()
    }


    public singIn()
    {
      this.isSingIn.emit()
    }

    public singOut()
    {
      this.isSingOut.emit()
    }

    public singUp(newUser)
    {
      this.isSingUp.emit(newUser)
    }
}
