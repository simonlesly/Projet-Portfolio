import { Component } from '@angular/core';
import { ManageBoxesService } from '../../service/manage-boxes.service';
import { Boxes } from '../../modules/Boxes';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-details-boxes',
  templateUrl: './details-boxes.component.html',
  styleUrl: './details-boxes.component.css'
})

  export class DetailsBoxesComponent {

    boxes: Array<Boxes>
    laBox:Boxes|undefined
    constructor(manageBoxesServices: ManageBoxesService, private route: ActivatedRoute) {
      this.boxes = []
      
      manageBoxesServices.getBoxes().subscribe((resultat) => {
        this.boxes = resultat
        const boxeId = Number(this.route.snapshot.paramMap.get('id'));
        console.log(boxeId);
        
       this.laBox= this.boxes.find((uneBox)=>uneBox.id==boxeId)
        console.log(this.laBox)
      })
    }
  }
