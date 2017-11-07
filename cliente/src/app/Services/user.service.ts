import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { User } from '../Models/User.model';


@Injectable()
export class UserService {
  public base: string = "http://localhost:8000/api/v1/users/";
  public options: RequestOptions;
  public headers: Headers;

  constructor( private http: Http, private authenticationService: AuthenticationService )
  {
    this.headers = new Headers(
    {
      'Authorization': 'Bearer ' + this.authenticationService.token,
      'Content-Type': 'application/json'
    });

    this.options = new RequestOptions({ headers: this.headers });


  }

  getUsers(): Observable<User[]>
  {
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerUser(user : User)
  {
    return this.http.post( this.base, JSON.stringify(user ), this.options).map((res: Response) => res.json());

  }

  getUser(id) : Observable<User>
  {
    return this.http.get(this.base+id, this.options).map((res: Response) => res.json());
  }

  editUser(user : User, id: number)
  {
    return this.http.put(this.base+id, JSON.stringify(user ), this.options).map((res: Response) => res.json());
  }

  deleteUser(id) {
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

