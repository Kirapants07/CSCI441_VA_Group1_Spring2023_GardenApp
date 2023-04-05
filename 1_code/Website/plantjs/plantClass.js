//PlantClass
//By Todd M. Wood
// currently a container for plants, will eventually be used to expand functionality

export default class Plant {

    constructor (plantId, plantName, plantType, plantSpacing, germination, harvest, plantingInstructions = null) {
        this.id = plantId;
        this.name = plantName;
        this.type = plantType;
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
    getSpacing(){
        return this.spacing;
    }
    getGermination(){
        return this.germ;
    }
    getHarvest(){
        return this.harv;

    }
    getPS(){
        if (!this.ps){
            return "No instructions";
        }
        return this.ps;
    }

}