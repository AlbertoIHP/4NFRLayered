import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';

import { EventService } from '../../Services/events.service'

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.css']
})
export class AdminComponent implements OnInit {
  public currentTab: any

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private events: EventService
    )
  {
    this.currentTab = 0
  }

  ngOnInit()
  {
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
    else if( index === 4 )
    {
      this.currentTab = 4
    }
    else if( index === 5 )
    {
      this.currentTab = 5
    }
    else if( index === 6 )
    {
      this.currentTab = 6
    }

  }



  openAddModal()
  {

    this.events.openAddModal(this.currentTab)

  }

}
