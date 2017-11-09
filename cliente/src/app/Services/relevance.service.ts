import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Relevance } from '../Models/Relevance.model';


@Injectable()
export class RelevanceService {
  public base: string = "http://localhost:8000/api/v1/relevances/";
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

  getRelevances(): Observable<Relevance[]>
  {
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerRelevance(relevance: Relevance)
  {
    return this.http.post( this.base, JSON.stringify(relevance), this.options).map((res: Response) => res.json());

  }

  getRelevance(id) : Observable<Relevance>
  {
    return this.http.get(this.base+id, this.options).map((res: Response) => res.json());
  }

  editRelevance(relevance: Relevance, id: number)
  {
    return this.http.put(this.base+id, JSON.stringify(relevance), this.options).map((res: Response) => res.json());
  }

  deleteRelevance(id) {
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}
