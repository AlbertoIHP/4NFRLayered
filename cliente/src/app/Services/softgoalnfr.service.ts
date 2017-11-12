import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { SoftgoalNfr } from '../Models/SoftgoalNfr.model';


@Injectable()
export class SoftgoalnfrService {
  public base: string = "http://localhost:8000/api/v1/softgoalNfrs/";
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

  getSoftgoalNfrs(): Observable<SoftgoalNfr[]>
  {
    this.setToken()
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerSoftgoalNfr(soft : SoftgoalNfr)
  {
    this.setToken()
    return this.http.post( this.base, JSON.stringify(soft ), this.options).map((res: Response) => res.json());

  }

  getSoftgoalNfr(id) : Observable<SoftgoalNfr>
  {
    this.setToken()
    return this.http.get(this.base+id, this.options).map((res: Response) => res.json());
  }

  editSoftgoalNfr(soft : SoftgoalNfr, id: number)
  {
    this.setToken()
    return this.http.put(this.base+id, JSON.stringify(soft ), this.options).map((res: Response) => res.json());
  }

  deleteSoftgoalNfr(id)
  {
    this.setToken()
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

