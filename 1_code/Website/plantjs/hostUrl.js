//HostUrl for making the connection
// By Todd M. Wood

// set params
const mainHost = "localhost";
const mainPath = "CSCI441_VA_Group1_Spring2023_GardenApp/1_code/API/api/plant/";
const header = "http://";

//function to create the url
export default function host (type,name,zone) {
    
    let defaultUrl = null;
    //build the url if there is a zone and name
    if (name && zone){
        defaultUrl = `${header}${mainHost}/${mainPath}?${type}=${name}&&zonenum?=number${zone}`;
    }
    //build the url if there is a name but no zone
    else if (name && !zone){
        
            defaultUrl = `${header}${mainHost}/${mainPath}?${type}=${name}`;
        }
    //otherwise just do a generic search
    else  {
        defaultUrl = `${header}${mainHost}/${mainPath}`;
    }

   return defaultUrl;

}