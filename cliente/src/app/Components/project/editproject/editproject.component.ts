import { Component, OnInit } from '@angular/core'
import { Router, ActivatedRoute } from '@angular/router'
import { EventService } from '../../../Services/events.service'

@Component({
  selector: 'app-editproject',
  templateUrl: './editproject.component.html',
  styleUrls: ['./editproject.component.css']
})
export class EditprojectComponent implements OnInit {
  public currentTab: any
  public alive: boolean

  constructor(private events: EventService, private router: Router)
  {
    this.events.clickEditProject()

    if(localStorage.getItem('currentUser'))
    {
      this.alive = true
      this.currentTab = 0
      this.events.adminHasClicked.subscribe( data => {
        this.alive = false
      })

      this.events.projectHasClicked.subscribe( data => {
        this.alive = false
      })
    }
    else
    {
      this.router.navigate(['login'])
    }
  }
  changeTab(tab)
  {
    var index = tab.selectedIndex

    if( index === 0 )
    {
     this.currentTab = 0
    }
    else if( index === 1 )
    {
      this.currentTab = 1
    }
    else if( index === 2 )
    {
      this.currentTab = 2
    }
    else if( index === 3 )
    {
      this.currentTab = 3
    }

  }



  openAddModal()
  {

    this.events.editProjectModal(this.currentTab)

  }

  ngOnInit() {
  }

}
