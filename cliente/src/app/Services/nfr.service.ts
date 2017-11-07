import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Nfr } from '../Models/Nfr.model';


@Injectable()
export class NfrService {
  public base: string = "http://localhost:8000/api/v1/nfrs/";
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

  getNfrs(): Observable<Nfr[]>
  {
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerNfr(nfr: Nfr)
  {
    return this.http.post( this.base, JSON.stringify(nfr), this.options).map((res: Response) => res.json());

  }

  getNfr(id) : Observable<Nfr>
  {
    return this.http.get(this.base+id, this.options).map((res: Response) => res.json());
  }

  editNfr(nfr: Nfr, id: number)
  {
    return this.http.put(this.base+id, JSON.stringify(nfr), this.options).map((res: Response) => res.json());
  }

  deleteNfr(id) {
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

