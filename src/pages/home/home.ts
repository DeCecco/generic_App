import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ApiProvider } from '../../providers/api/api';
import { AngularFirestore/*, AngularFirestoreDocument */} from 'angularfire2/firestore';
//import { Observable } from 'rxjs/Observable';
//import { MenuPage } from '../menu/menu';

@Component({
  selector: 'page-home',
  templateUrl: 'home.html'
})
export class HomePage {
  formLogin: FormGroup;
  mail: string;
  password: string;
  constructor(public navCtrl: NavController, public formBuilder: FormBuilder, private ApiProvider: ApiProvider, private db: AngularFirestore) {
    this.formLogin = formBuilder.group({
      mail: [this.mail, Validators.compose([Validators.maxLength(30), Validators.pattern('[a-zA-Z ]*'), Validators.required])],
      password: [this.password, Validators.compose([Validators.maxLength(30), Validators.required])]
    });


  }

  registrar() {
    this.db.collection("usuarios").add({
      nombre: "Pablo",
      apellido: "De Cecco",
      mail: 'pablo.dececco@hotmail.com',
      password: '722567'
    })
      .then((docRef) => {
        console.log("Document written with ID: ", docRef.id);
      })
      .catch((error) => {
        console.error("Error adding document: ", error);
      });
  }



  ingresar() {
    this.ApiProvider.verificarUsuario(this.mail, this.password).then(response => {
      console.info(response)

      var array = [{
        "nombre": response[0].nombre, "apellido": response[0].apellido, "email": response[0].mail, "tipo": response[0].idtipo, "img": response[0].idimagen
      }];
      this.ApiProvider.token(array).then(tk => {
        console.warn(tk)
        var arr = [{ "token": tk }];
        this.ApiProvider.payLoad(arr).then(response =>{
          console.info(response)
        }).catch(error=>{

        })
        this.ApiProvider.verificarToken(arr).then(response => {
          console.info(response)
        }).catch(error => {

        })
      }).catch(error => {
        console.log(error);
      });
      //this.local.set("userInfo",data[0]);              
      //this.navCtrl.setRoot(PrincipalPage);



    }).catch(error => {
      console.warn(error)
    })
  }
  administrador() {

    this.mail = 'pablo.dececco@hotmail.com';
    this.password = '722567';
    this.ingresar();
  }
}
