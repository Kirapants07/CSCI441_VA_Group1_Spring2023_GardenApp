//getPlants
//Todd M. Wood
//Gets and Displays Plants

import Plant from "./plantClass.js";
import host from './hostUrl.js';

let url = null;


const plantList = [];
//Function to fetch and get plants
const getPlants = async (plantName) => {
    //set to lowercase for easy compares
    plantName = plantName.toLowerCase();
    console.log(plantName);
    let jsonData = null;
    let type = 'name';

    // check for the type of request and get data
    // if no name provided
    // check for type
    if (!plantName){
        type = null;
    }
    else if (plantName == 'fruit' || plantName == 'vegetable' || plantName == 'herb')
    {
        type = 'type';
    }

    
    url = host(type,plantName);
    let response = await fetch (url);

    jsonData = await response.json();
    //if there is a message then nothing was found
    if (jsonData.message){
        // check for plurals
        type = 'pluralName';
        url = host(type,plantName);
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
        let temp = jsonData[i];
        const newPlant = new Plant(temp.id,temp.name,temp.type,temp.spacing,temp.germinationInformation,temp.harvestInformation);
        plantList.push(newPlant);   
    }
}


// Place the plants onto the website
const displayPlants = async (plantName) => {

    await getPlants(plantName);
    
    let main = document.querySelector('main');

    let element = (plantList) ? await createPlantTable(plantList) : null; 
    
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

    title.appendChild(tName);
    title.appendChild(tType);
    title.appendChild(tSpacing);
    title.appendChild(tGerm);
    title.appendChild(tHarv);

    // create table elements
    for(let i=0; i < plants.length; i++)
    {
        let plant = plants[i];
    
        let newRow = document.createElement("tr"); 
        table.appendChild(newRow);

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
    e.preventDefault();
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
    displayPlants(inputName);  // call for display
}); 



  



