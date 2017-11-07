import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Role } from '../Models/Role.model';


@Injectable()
export class RoleService {
  public base: string = "http://localhost:8000/api/v1/roles/";
  public options: RequestOptions;
  public headers: Headers;

  constructor(private http: Http, private authenticationService: AuthenticationService)
  {
    this.headers = new Headers(
    {
      'Authorization': 'Bearer ' + this.authenticationService.token,
      'Content-Type': 'application/json'
    });

    this.options = new RequestOptions({ headers: this.headers });


  }

  getRoles(): Observable<Role[]>
  {
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerRole(rol : Role)
  {
    return this.http.post( this.base, JSON.stringify(rol ), this.options).map((res: Response) => res.json());

  }

  getRole(id) : Observable<Role>
  {
    return this.http.get(this.base+id, this.options).map((res: Response) => res.json());
  }

  editRole(rol : Role, id: number)
  {
    return this.http.put(this.base+id, JSON.stringify(rol ), this.options).map((res: Response) => res.json());
  }

  deleteRole(id) {
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

