import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Functionality } from '../Models/Functionality.model';
import { address } from './address'

@Injectable()
export class FunctionalityService {
  public base: string = address+"/functionalities";
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

  getFunctionalities(): Observable<Functionality[]>
  {
    this.setToken()
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerFunctionality(func: Functionality)
  {
    this.setToken()
    return this.http.post( this.base, JSON.stringify(func), this.options).map((res: Response) => res.json());

  }

  getFunctionality(id) : Observable<Functionality>
  {
    this.setToken()
    return this.http.get(this.base+'/'+id, this.options).map((res: Response) => res.json());
  }

  editFunctionality(func: Functionality, id: number)
  {
    this.setToken()
    return this.http.put(this.base+id, JSON.stringify(func), this.options).map((res: Response) => res.json());
  }

  deleteFunctionality(id)
  {
    this.setToken()
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

