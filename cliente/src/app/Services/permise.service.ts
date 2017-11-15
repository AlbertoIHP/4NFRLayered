import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Permise } from '../Models/Permise.model';
import { address } from './address'

@Injectable()
export class PermiseService {
  public base: string = address+"/permises";
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

  getPermises(): Observable<Permise[]>
  {
    this.setToken()
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerPermise(permise: Permise)
  {
    this.setToken()
    return this.http.post( this.base, JSON.stringify(permise), this.options).map((res: Response) => res.json());

  }

  getPermise(id) : Observable<Permise>
  {
    this.setToken()
    return this.http.get(this.base+'/'+id, this.options).map((res: Response) => res.json());
  }

  editPermise(permise: Permise, id: number)
  {
    this.setToken()
    return this.http.put(this.base+'/'+id, JSON.stringify(permise), this.options).map((res: Response) => res.json());
  }

  deletePermise(id)
  {
    this.setToken()
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

