//PlantClass
//By Todd M. Wood
// currently a container for plants, will eventually be used to expand functionality

export default class Plant {

    constructor (plantId, plantName, plantType, plantDate = '0000-00-00', plantSpacing, germination, harvest, plantingInstructions = null) {
        this.id = plantId;
        this.name = plantName;
        this.type = plantType;
        this.date = plantDate;
        this.spacing = plantSpacing;
        this.germ = germination;
        this.harv = harvest;
        this.ps = plantingInstructions;
    }
    getId(){
        return this.id;
    }
    getName(){
        return this.name;
    }
    getType(){
        return this.type;
    }

    getDate(){

        let splitDate = this.date.split(""); 
       
        const newDate = `${splitDate[5]}${splitDate[6]}-${splitDate[8]}${splitDate[9]}-${splitDate[0]}${splitDate[1]}${splitDate[2]}${splitDate[3]}`;
        return newDate;
    }
    getSpacing()
    {
        return this.spacing;
    }
    getGermination(){
        return this.germ;
    }
    getHarvest(){
        return this.harv;
    }

}