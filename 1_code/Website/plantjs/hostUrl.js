//HostUrl for making the connection
// By Todd M. Wood

// set params
const mainHost = "localhost";
const mainPlantPath = "CSCI441_VA_Group1_Spring2023_GardenApp/1_code/API/api/plant/";
const mainUserdataPath = "CSCI441_VA_Group1_Spring2023_GardenApp/1_code/API/api/userdata/";
const header = "http://";

//function to create the url
function host (type,name,zone) {
    
    let defaultUrl = null;
    //build the url if there is a zone and name
    if (name && zone){
        defaultUrl = `${header}${mainHost}/${mainPlantPath}?${type}=${name}&&zonenum?=number${zone}`;
    }
    //build the url if there is a name but no zone
    else if (name && !zone){
        
            defaultUrl = `${header}${mainHost}/${mainPlantPath}?${type}=${name}`;
        }
    //otherwise just do a generic search
    else  {
        defaultUrl = `${header}${mainHost}/${mainPlantPath}`;
    }

   return defaultUrl;

}
//function to create the url
function uHost (userId) {

    if(!userId)
    {
        let userUrl = `${header}${mainHost}/${mainUserdataPath}`;
        return userUrl;
    } else {
        let userUrl = `${header}${mainHost}/${mainUserdataPath}?id=${userId}`;
        return userUrl;
    }

}
export {host, uHost}