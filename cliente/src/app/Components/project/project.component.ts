import { Component, OnInit } from '@angular/core';

import { Router, ActivatedRoute } from '@angular/router';


@Component({
  selector: 'app-project',
  templateUrl: './project.component.html',
  styleUrls: ['./project.component.css']
})
export class ProjectComponent implements OnInit {

  constructor(private router: Router)
  {
    if(localStorage.getItem('currentUser'))
    {

    }
    else
    {
      this.router.navigate(['login'])
    }
  }

  ngOnInit() {
  }

}
