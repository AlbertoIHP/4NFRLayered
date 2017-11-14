import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Role } from '../Models/Role.model';
import { address } from './address'

@Injectable()
export class RoleService {
  public base: string = address+"/roles";
  public options: RequestOptions;
  public headers: Headers;

  constructor(private http: Http, private authenticationService: AuthenticationService)
  {
    this.setToken()
  }

  setToken()
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
    this.setToken()
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerRole(rol : Role)
  {
    this.setToken()
    return this.http.post( this.base, JSON.stringify(rol ), this.options).map((res: Response) => res.json());

  }

  getRole(id) : Observable<Role>
  {
    this.setToken()
    return this.http.get(this.base+id, this.options).map((res: Response) => res.json());
  }

  editRole(rol : Role, id: number)
  {
    this.setToken()
    return this.http.put(this.base+id, JSON.stringify(rol ), this.options).map((res: Response) => res.json());
  }

  deleteRole(id)
  {
    this.setToken()
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

