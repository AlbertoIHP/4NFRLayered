import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Stakeholder } from '../Models/Stakeholder.model';


@Injectable()
export class StakeholderService {
  public base: string = "http://localhost:8000/api/v1/stakeholders/";
  public options: RequestOptions;
  public headers: Headers;

  constructor( private http: Http, private authenticationService: AuthenticationService )
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

  getStakeholders(): Observable<Stakeholder[]>
  {
    this.setToken()
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerStakeholder(stake : Stakeholder)
  {
    this.setToken()
    return this.http.post( this.base, JSON.stringify(stake ), this.options).map((res: Response) => res.json());

  }

  getStakeholder(id) : Observable<Stakeholder>
  {
    this.setToken()
    return this.http.get(this.base+id, this.options).map((res: Response) => res.json());
  }

  editStakeholder(stake : Stakeholder, id: number)
  {
    this.setToken()
    return this.http.put(this.base+id, JSON.stringify(stake ), this.options).map((res: Response) => res.json());
  }

  deleteStakeholder(id)
  {
    this.setToken()
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

