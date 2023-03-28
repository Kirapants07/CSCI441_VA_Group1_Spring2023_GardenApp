//getPlants
//Todd M. Wood
//Gets and Displays Plants

import Plant from "./plantClass.js";


const plantList = [];
//Function to fetch and get plants
const getPlants = async (plantName) => {
    console.log(plantName);
    let jsonData = null;
    // check for the type of request
    if (!plantName){
        const response = await fetch ("http://localhost/garden/CSCI441_VA_Group1_Spring2023_GardenApp/API/api/plant/");
        jsonData = await response.json();
    }
    else{
        let response = await fetch (`http://localhost/garden/CSCI441_VA_Group1_Spring2023_GardenApp/API/api/plant/?name=${plantName}`);

        jsonData = await response.json();
        if (jsonData.message){
            response = await fetch (`http://localhost/garden/CSCI441_VA_Group1_Spring2023_GardenApp/API/api/plant/?pluralName=${plantName}`);
            
            jsonData = await response.json();

            if (jsonData.message){
            console.log(jsonData.message);
            const div = document.createElement("div");
            const fail = document.createTextNode("No Plants Where Found");
            div.append(fail);
            let main = document.querySelector('main');
            main.append(div);
            return false
            }
        }
    }

    //
    for (let i = 0; i < jsonData.length; i++){
        let temp = jsonData[i];
        const newPlant = new Plant(temp.id,temp.name,temp.type,temp.spacing,temp.germinationInformation,temp.harvestInformation);
        plantList.push(newPlant);   
    }
}

const displayPlants = async (plantName) => {

    await getPlants(plantName);
    
    let main = document.querySelector('main');
    let element = (plantList) ? await createPlant(plantList) : 'There are no Plants to Display'; 
    
    if (element)
    {
        main.append(element);
    }
    return element;

}


async function createPlant(plants)
{
    if (plants.length <= 0) return;

    let fragment = document.createDocumentFragment();
    let table = document.createElement("table");
    table.setAttribute("id", "pTable");
    fragment.appendChild(table);

    let title = document.createElement("tr");
    table.appendChild(title);

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

document.getElementById("pSearch").addEventListener("submit", (e) => {
    e.preventDefault();
    plantList.length = 0; // reset plantlist
    const pTable = document.getElementById("pTable");
    if(pTable)
    {
        pTable.parentNode.removeChild(pTable);
    }
    let inputName = document.getElementById("pName").value;
    displayPlants(inputName);    
}); 



  



