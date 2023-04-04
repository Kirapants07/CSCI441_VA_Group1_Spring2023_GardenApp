//getPlants
//Todd M. Wood
//Gets and Displays Plants

import Plant from "./plantClass.js";
import host from './hostUrl.js';

let url = null;


const plantList = [];
//Function to fetch and get plants


const getPlants = async (plantName, zoneNum) => {
    //set to lowercase for easy compares
    console.log(zoneNum);
    plantName = plantName.toLowerCase();

    let jsonData = null;
    let type = 'name';

    // check for the type of request
    if (!plantName){
        type = null;
    } 
    else if (plantName == 'fruit' || plantName == 'vegetable' || plantName == 'herb' || plantName == 'fruits' || plantName == 'vegetables' || plantName == 'herbs')
    {
        type = 'type';

        //if type is plural, make non plural
        if (plantName == 'fruits' ) { plantName = 'fruit'; }
        else if (plantName == 'vegetables') {plantName = 'vegetable';}
        else if (plantName == 'herbs') {plantName = 'herb';}
        
    }
    
    // build the url
    url = host(type,plantName,zoneNum);
    let response = await fetch (url);

    jsonData = await response.json();
    //if there is a message then nothing was found
    if (jsonData.message){
        // check for plurals
        type = 'pluralName';
        // rebuild the url for plurals
        url = host(type,plantName, zoneNum);
        response = await fetch (url);
            
        jsonData = await response.json();

        // populate a fail message
        if (jsonData.message){
        console.log(jsonData.message);
        const div = document.createElement("div");
        div.setAttribute("id", "noFoundDiv");
        const fail = document.createTextNode("No Plants Were Found");
        div.append(fail);
        let main = document.querySelector('main');
        main.append(div);
        return false
        }
    }


    // create an array of plant objects
    for (let i = 0; i < jsonData.length; i++){
        const temp = jsonData[i];
        const newPlant = new Plant(temp.id,temp.name,temp.type,temp.spacing,temp.germinationInformation,temp.harvestInformation);
        
        plantList.push(newPlant);   
    }
}


// Place the plants onto the website
const displayPlants = async (plantName, zone) => {

    // call the function to get the plants
    await getPlants(plantName, zone);
    
    // grab the main element
    let main = document.querySelector('main');

    // call the function to create the table 
    let element = (plantList) ? await createPlantTable(plantList) : null; 
    // append the table to the page
    if (element)
    {
        main.append(element);
    }
    return element;

}

// Create a plant table
async function createPlantTable(plants)
{
    if (plants.length <= 0) return;

    //create a fragment for the table
    let fragment = document.createDocumentFragment();
    
    //create table
    let table = document.createElement("table");
    table.setAttribute("id", "pTable");
    fragment.appendChild(table);

    // create header row
    let title = document.createElement("tr");
    table.appendChild(title);

    // create header elements
    let tName = document.createElement("th");
    tName.textContent = "Name";
    let tType = document.createElement("th");
    tType.textContent = "Type";
    let tSpacing = document.createElement("th");
    tSpacing.textContent = "Spacing";
    let tHarv = document.createElement("th");
    tHarv.textContent = "Germination";
    let tGerm = document.createElement("th");
    tGerm.textContent = "Harvest";

    //append header elements
    title.appendChild(tName);
    title.appendChild(tType);
    title.appendChild(tSpacing);
    title.appendChild(tGerm);
    title.appendChild(tHarv);

    // create table elements
    for(let i=0; i < plants.length; i++)
    {
        let plant = plants[i];
        let ps = null; // for planting instructions
        
        //create the row
        let newRow = document.createElement("tr"); 
        table.appendChild(newRow);

        // create each item in the row
        let name = document.createElement("td");
        name.textContent =  plant.getName();
        let type = document.createElement("td");
        type.textContent =  plant.getType();
        let spacing = document.createElement("td");
        spacing.textContent =  plant.getSpacing();
        let germ = document.createElement("td");
        germ.textContent =  plant.getGermination();
        let harv = document.createElement("td");
        harv.textContent =  plant.getHarvest();
     
        // append row elements
        newRow.appendChild(name);
        newRow.appendChild(type);
        newRow.appendChild(spacing);
        newRow.appendChild(germ);
        newRow.appendChild(harv);

        
    }
    return fragment;
}

// add element listener
document.getElementById("pSearch").addEventListener("submit", (e) => {

    e.preventDefault(); // prevent default error
    plantList.length = 0; // reset plantlist
    const pTable = document.getElementById("pTable"); // check for table
    const noFou = document.getElementById("noFoundDiv");
    if(pTable)
    {
        pTable.parentNode.removeChild(pTable); // delete existing table
    }
    if(noFou)
    {
        noFou.parentNode.removeChild(noFou); // delete not found message
    }
    let inputName = document.getElementById("pName").value; // get user value

    //check to see if the user entered a zone
    const zoneNum = document.getElementById("zoneNum"); // check for zone
    
    let zone = 0; // set a default zone of 0
    // if there is a zone get the number
    if (zoneNum)
    {
        zone = zoneNum.textContent; 
    }
    displayPlants(inputName, zone);  // call for display
}); 



  



