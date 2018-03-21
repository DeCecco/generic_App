import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ApiProvider } from '../../providers/api/api';
//import { MenuPage } from '../menu/menu';

@Component({
  selector: 'page-home',
  templateUrl: 'home.html'
})
export class HomePage {
  formLogin: FormGroup;
  mail: string;
  password: string;
  constructor(public navCtrl: NavController, public formBuilder: FormBuilder, private ApiProvider: ApiProvider) {
    this.formLogin = formBuilder.group({
      mail: [this.mail, Validators.compose([Validators.maxLength(30), Validators.pattern('[a-zA-Z ]*'), Validators.required])],
      password: [this.password, Validators.compose([Validators.maxLength(30), Validators.required])]
    });
  }

  ingresar() {
    this.ApiProvider.verificarUsuario(this.mail,this.password).then(response=>{
      console.info(response)
    }).catch(error=>{
      console.warn(error)
    })   
  }
  administrador() {

    this.mail = 'pablo.dececco@hotmail.com';
    this.password = '722567';
    this.ingresar();
  }
}
