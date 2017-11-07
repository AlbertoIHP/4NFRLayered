import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {

  constructor(public router: Router)
  {

  }

  goProject()
  {
    this.router.navigate([''])
  }

  goAdmin()
  {
    this.router.navigate(['admin'])
  }

  singOut()
  {
    this.router.navigate(['login'])
  }
}
