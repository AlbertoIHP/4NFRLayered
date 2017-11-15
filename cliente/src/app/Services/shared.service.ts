import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { address } from './address'

@Injectable()
export class SharedService {
  public base: string = address+"/collaborators";
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

  index(): Observable<any[]>
  {
    this.setToken()
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  store(category: any)
  {
    return this.http.post( this.base, JSON.stringify(category), this.options).map((res: Response) => res.json());

  }

  get(id) : Observable<any>
  {
    this.setToken()
    return this.http.get(this.base+'/'+id, this.options).map((res: Response) => res.json());
  }

  update(category: any, id: number)
  {
    this.setToken()
    return this.http.put(this.base+'/'+id, JSON.stringify(category), this.options).map((res: Response) => res.json());
  }

  destroy(id)
  {
    this.setToken()
    return this.http.delete(this.base+'/'+id, this.options).map((res: Response) => res.json());
  }


}

