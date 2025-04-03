import { Component } from '@angular/core';
import { Observable } from 'rxjs';
import { Boxes } from '../../modules/Boxes';
import { ManageBoxesService } from '../../service/manage-boxes.service';
import { ManagePaniersService } from '../../service/manage-paniers.service';
import { Panier } from '../../modules/Panier';
import { environment } from '../../../environments/environment';

@Component({
  selector: 'app-nosboxes',
  templateUrl: './nosboxes.component.html',
  styleUrl: './nosboxes.component.css'
})
export class NosboxesComponent {

  boxes: Array<Boxes>
  constructor(private manageBoxesService: ManageBoxesService, private panierService: ManagePaniersService){
  this.boxes = []

  this.manageBoxesService.getBoxes().subscribe((resultat)=>{
  console.log(this.boxes)
  this.boxes = resultat
})
}
ajouter(uneBox:Boxes){
  this.panierService.addBoxes(uneBox,1)
}
// méthode pour calculer le prix moyen des boxes
moyennePrix(){
  let sommePrix=0
  //calcule de la sommes de toute les boxes
  for (let boxe of this.boxes){
    sommePrix+= boxe.prix
  }
// calcule la moyenne
const moyennePrix = sommePrix / this.boxes.length;
  //retourne la moyenne
  return moyennePrix.toFixed(2)
}
}
