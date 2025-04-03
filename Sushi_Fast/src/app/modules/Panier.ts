import { Boxes } from "./Boxes"
import { LigneBoxes } from "./LigneBoxes"

export class Panier{
    id: number
    listeDeBoxe: Array<LigneBoxes>
    statut:boolean

    constructor(id:number,listeDeBoxe: Array <any>,statut:boolean,){
        this.id= id
        this.listeDeBoxe= listeDeBoxe
        this.statut= statut
    }
    getPrix(){
        let prix =0
        for (const uneLigne of this.listeDeBoxe) {
            prix+=uneLigne.boxe.prix * uneLigne.qte
        }
        return prix
    }
}