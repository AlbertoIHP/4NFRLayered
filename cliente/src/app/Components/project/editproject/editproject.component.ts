import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
@Component({
  selector: 'app-editproject',
  templateUrl: './editproject.component.html',
  styleUrls: ['./editproject.component.css']
})
export class EditprojectComponent implements OnInit {

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
