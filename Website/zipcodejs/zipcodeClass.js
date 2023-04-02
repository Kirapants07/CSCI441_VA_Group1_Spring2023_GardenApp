//ZipcodeClass
//By Gavin J Cyr

export default class Zipcode {

    constructor (zipId, zipcode, plantingZone, plantingZoneSub, tempRange) {
        this.id = zipId;
        this.zipcode = zipcode;
        this.zone = plantingZone;
        this.zoneSub = plantingZoneSub;
        this.tempRange = tempRange;
    }
    getId(){
        return this.id;
    }
    getZipcode(){
        return this.zipcode;
    }
    getPlantingZone(){
        return this.zone;
    }
    getZoneSub(){
        return this.zoneSub;
    }
    getTempRange(){
        return this.tempRange;
    }
}