import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
@Component({
  selector: 'app-viewproject',
  templateUrl: './viewproject.component.html',
  styleUrls: ['./viewproject.component.css']
})
export class ViewprojectComponent implements OnInit {

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
