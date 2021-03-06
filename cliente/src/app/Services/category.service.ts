import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Category } from '../Models/Category.model';
import { address } from './address'

@Injectable()
export class CategoryService {
  public base: string = address+"/categories";
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

  getCategories(): Observable<Category[]>
  {
    this.setToken()
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerCategory(category: Category)
  {
    return this.http.post( this.base, JSON.stringify(category), this.options).map((res: Response) => res.json());

  }

  getCategory(id) : Observable<Category>
  {
    this.setToken()
    return this.http.get(this.base+'/'+id, this.options).map((res: Response) => res.json());
  }

  editCategory(category: Category, id: number)
  {
    this.setToken()
    return this.http.put(this.base+'/'+id, JSON.stringify(category), this.options).map((res: Response) => res.json());
  }

  deleteCategory(id)
  {
    this.setToken()
    return this.http.delete(this.base+'/'+id, this.options).map((res: Response) => res.json());
  }


}

