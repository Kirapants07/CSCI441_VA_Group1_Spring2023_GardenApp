//getZipcode
//Gavin J Cyr
//Gets and Displays Zipcode

import Zipcode from "./zipcodeClass.js";

//Function to fetch and get Zipcode
let newZipcode;
export default async function getZipcodes(zipcode) {
    console.log(zipcode);
    let jsonData = null;
    // check for the type of request and get data
    if (!zipcode){
        const div = document.createElement("div");
        div.setAttribute("id", "noFoundDiv");
        const fail = document.createTextNode("Please enter a five digit zipcode.");
        div.append(fail);
        let main = document.querySelector('main');
        main.append(div);
        return false;
    }
    else{
        let response = await fetch (`http://localhost/CSCI441_VA_Group1_Spring2023_GardenApp/1_code/API/api/zipcode/?zipcode=${zipcode}`);

        jsonData = await response.json();
        if (jsonData.message){
            // populate a fail message
            if (jsonData.message){
            console.log(jsonData.message);
            const div = document.createElement("div");
            div.setAttribute("id", "noFoundDiv");
            const fail = document.createTextNode("No Zipcode Was Found");
            div.append(fail);
            let main = document.querySelector('main');
            main.append(div);
            return false;
            }
        }
    }
    let temp = jsonData[0];
    newZipcode = new Zipcode(temp.id, temp.zipCode, temp.plantingZone[0].number, temp.plantingZoneSub, temp.tempRange);
    const div = document.createElement("div");
    div.setAttribute("id", "noFoundDiv");
    const success = document.createTextNode("Search Results:");
    div.append(success);
    let main = document.querySelector('main');
    main.append(div);
}

// Place the Zipcode onto the website
const displayZipcode = async (zipcode) => {

    await getZipcodes(zipcode);
    
    let main = document.querySelector('main');

    let element = (newZipcode) ? await createZipcodeTable(newZipcode) : null; 
    
    if (element)
    {
        main.append(element);
    }
    return element;

}

// Create a zipcode table
async function createZipcodeTable(zipcode)
{
    if (zipcode.length <= 0) return;

    let fragment = document.createDocumentFragment();
    
    //create table
    let table = document.createElement("table");
    table.setAttribute("id", "zTable");
    fragment.appendChild(table);

    // create header row
    let title = document.createElement("tr");
    table.appendChild(title);

    // create header elements
    let tZipcode = document.createElement("th");
    tZipcode.textContent = "Zipcode";
    let tplantZone = document.createElement("th"); 
    tplantZone.textContent = "Planting Zone";
    let tZoneSub = document.createElement("th");
    tZoneSub.textContent = "Sub Zone";
    let tTempRange = document.createElement("th");
    tTempRange.textContent = "Temperature Range(\u00B0F)";

    title.appendChild(tZipcode);
    title.appendChild(tplantZone);
    title.appendChild(tZoneSub);
    title.appendChild(tTempRange);

    // create table elements
    let newRow = document.createElement("tr"); 
    table.appendChild(newRow);

    let zip = document.createElement("td");
    zip.textContent =  zipcode.getZipcode();
    let plantZone = document.createElement("td");
    plantZone.setAttribute("id", "zoneNum");
    plantZone.textContent =  zipcode.getPlantingZone();
    let zoneSub = document.createElement("td");
    zoneSub.textContent =  zipcode.getZoneSub();
    let tempRange = document.createElement("td");
    tempRange.textContent =  zipcode.getTempRange();

    newRow.appendChild(zip);
    newRow.appendChild(plantZone);
    newRow.appendChild(zoneSub);
    newRow.appendChild(tempRange);

    return fragment;
}

// add element listener
document.getElementById("zSearch").addEventListener("submit", (e) => {
    e.preventDefault();
    const zTable = document.getElementById("zTable"); // check for table
    const noFou = document.getElementById("noFoundDiv");
    if(zTable)
    {
        zTable.parentNode.removeChild(zTable); // delete existing table
    }
    if(noFou)
    {
        noFou.parentNode.removeChild(noFou); // delete not found message
    }
    let inputName = document.getElementById("zName").value; // get user value
    displayZipcode(inputName);  // call for display
}); 
