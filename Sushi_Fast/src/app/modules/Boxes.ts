export class Boxes{
   id: number
   nom: string
   pieces:  number
   prix:number
   image: string
   aliments:Array <any>
   saveurs: Array <any>

    constructor(id:number, nom:string, pieces:number, prix: number, image: string,aliments: Array <any>, saveurs: Array <any>,){
        this.id= id
        this.nom= nom
        this.pieces= pieces
        this.prix= prix
        this.image= image
        this.aliments= aliments
        this.saveurs= saveurs
    }
}