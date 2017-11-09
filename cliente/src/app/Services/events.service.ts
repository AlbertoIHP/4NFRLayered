import { Injectable, EventEmitter } from '@angular/core'

@Injectable()
export class EventService {
    public isSingIn: any
    public isSingOut: any
    public isSingUp: any

    //Eventos para las TAB de Admin
    public openUser: any
    public openRole: any
    public openNfr: any
    public openArea: any
    public openCategory: any
    public openProfession: any
    public openRelevance:any

    //Eventos para las TAB de editProject
    public openStake: any
    public openNon: any
    public openGoal: any
    public openSoft: any

    editProjectModal(index)
    {
      if( index === 0 )
      {
        this.openStake.emit()
      }
      else if( index === 1 )
      {
        this.openGoal.emit()
      }
      else if( index === 2 )
      {
        this.openSoft.emit()
      }
      else if( index === 3 )
      {
        this.openNon.emit()
      }


    }

    constructor() {
        this.isSingIn = new EventEmitter()
        this.isSingOut = new EventEmitter()
        this.isSingUp = new EventEmitter()
        this.openUser = new EventEmitter()
        this.openRole = new EventEmitter()
        this.openNfr = new EventEmitter()
        this.openArea = new EventEmitter()
        this.openCategory = new EventEmitter()
        this.openProfession = new EventEmitter()
        this.openRelevance = new EventEmitter()
        this.openNon = new EventEmitter()
        this.openStake = new EventEmitter()
        this.openNon = new EventEmitter()
        this.openGoal = new EventEmitter()
        this.openSoft = new EventEmitter()


    }

    public openAddModal(index)
    {
      if( index === 0 )
      {
        this.openUser.emit()
      }
      else if( index === 1 )
      {
        this.openRole.emit()
      }
      else if( index === 2 )
      {
        this.openNfr.emit()
      }
      else if( index === 3 )
      {
        this.openArea.emit()
      }
      else if( index === 4 )
      {
        this.openCategory.emit()
      }
      else if( index === 5 )
      {
        this.openProfession.emit()
      }
      else if( index === 6 )
      {
        this.openRelevance.emit()
      }
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
