//HostUrl for making the connection
// By Todd M. Wood

// set params
const mainHost = "localhost";
const mainPath = "CSCI441_VA_Group1_Spring2023_GardenApp/API/api/plant/";
const priorPath = "garden";
const header = "http://";

//function to create the url
export default function host (type,name) {
    
    let defaultUrl = null;
    // if no type
    if (!type){
        defaultUrl = `${header}${mainHost}/${priorPath}/${mainPath}`;
    }
    // set the type
    else {
        defaultUrl = `${header}${mainHost}/${priorPath}/${mainPath}?${type}=${name}`;
    }

    return defaultUrl;

}