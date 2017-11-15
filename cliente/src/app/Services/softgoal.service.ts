import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Softgoal } from '../Models/Softgoal.model';
import { address } from './address'

@Injectable()
export class SoftgoalService {
  public base: string = address+"/softgoals";
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

  getSoftgoals(): Observable<Softgoal[]>
  {
    this.setToken()
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerSoftgoal(soft : Softgoal)
  {
    this.setToken()
    return this.http.post( this.base, JSON.stringify(soft ), this.options).map((res: Response) => res.json());

  }

  getSoftgoal(id) : Observable<Softgoal>
  {
    this.setToken()
    return this.http.get(this.base+'/'+id, this.options).map((res: Response) => res.json());
  }

  editSoftgoal(soft : Softgoal, id: number)
  {
    this.setToken()
    return this.http.put(this.base+'/'+id, JSON.stringify(soft ), this.options).map((res: Response) => res.json());
  }

  deleteSoftgoal(id)
  {
    this.setToken()
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

