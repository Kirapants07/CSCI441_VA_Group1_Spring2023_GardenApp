//PlantClass
//By Todd M. Wood

export default class Plant {

    constructor (plantId, plantName, plantType, plantSpacing, germination, harvest) {
        this.id = plantId;
        this.name = plantName;
        this.type = plantType;
        this.spacing = plantSpacing;
        this.germ = germination;
        this.harv = harvest;
    
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

}