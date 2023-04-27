//userPlants
//Todd M. Wood
//Gets and Displays Plants

import Plant from "./plantClass.js";
import {uHost, host} from './hostUrl.js';

let url = null;

const uPlantList = [];
let userData = null;
const info = "af91bf21-cf52-11ed-9782-244bfe7dd4fe";
//Function to fetch and get plants


async function getUserInfo(UID) {
    // build the url
    let url = uHost(UID);
    let userResp = await fetch(url);

    userData = await userResp.json();
   
    if (userData.message){
        tableCheck();
        const div = document.createElement("div");
        div.setAttribute("id", "noUFoundDiv");
        const fail = document.createTextNode("You have no plants");
        div.append(fail);
        let main = document.getElementById("myPlants");
        main.prepend(div);
        return false
    }
    await getUserPlants();

}

async function getUserPlants()  {

    // grab a generic url
    url = host();

    // loop through the users plants to grab each one.
    for (let i = 0; i < userData.length; i++){
        let response = await fetch(`${url}?id=${userData[i].plantId}`);
        const plantData = await response.json();
        const temp = plantData[0];
        const newPlant = new Plant(temp.id,temp.name,temp.type,userData[i].date,temp.spacing,temp.germinationInformation,temp.harvestInformation);
        uPlantList.push(newPlant);   
    }
    const div = document.createElement("div");
    div.setAttribute("id", "noUFoundDiv");
    const success = document.createTextNode("Your plants:");
    div.append(success);
    let main = document.getElementById('myPlants');
    main.append(div);    

}

// Place the plants onto the website
async function displayUserPlants (UID) {

    // call the function to get the plants
    await getUserInfo(UID);
    // grab the main element
    let main = document.getElementById('myPlants');
   // call the function to create the table 

    let element = uPlantList ? await createPlantTable(uPlantList) : null; 
    // append the table to the page
    if (element)
    {
        main.append(element);
    }

    removePlant();
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
    table.setAttribute("id", "uTable");
    fragment.appendChild(table);

    // create header row
    let title = document.createElement("tr");
    table.appendChild(title);

    // create header elements
    let tName = document.createElement("th");
    tName.textContent = "Name";
    let tType = document.createElement("th");
    tType.textContent = "Type";
    let tDate = document.createElement("th");
    tDate.textContent = "Date Planted;"
    let tSpacing = document.createElement("th");
    tSpacing.textContent = "Spacing";
    let tGerm = document.createElement("th");
    tGerm.textContent = "Germination";
    let tHarv = document.createElement("th");
    tHarv.textContent = "Harvest";
    let btn = document.createElement("th");
    btn.textContent = "";

    //append header elements
    title.appendChild(tName);
    title.appendChild(tType);
    title.appendChild(tDate);
    title.appendChild(tSpacing);
    title.appendChild(tGerm);
    title.appendChild(tHarv);
    title.appendChild(btn);


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
        let date = document.createElement("td");
        date.textContent = plant.getDate();
        let spacing = document.createElement("td");
        spacing.textContent =  plant.getSpacing();
        let germ = document.createElement("td");
        germ.textContent =  plant.getGermination();
        let harv = document.createElement("td");
        harv.textContent =  plant.getHarvest();

        let btnRow = document.createElement("td");
        btnRow.innerHTML = (`
            <button alt="delete"> 
                <span id="${plant.getId()}" class="remButton material-icons md-36">
                    delete
                </span>
            </button>
        `);        
     
        // append row elements
        newRow.appendChild(name);
        newRow.appendChild(type);
        newRow.appendChild(date);
        newRow.appendChild(spacing);
        newRow.appendChild(germ);
        newRow.appendChild(harv);
        newRow.appendChild(btnRow);

    }
    return fragment;
}

async function addPlant(id,date='0000-00-00')
{
    let UID = null;
    if (!userData || userData.message) UID = info;
    else UID = userData[0].userId;

    url = uHost(null);
    const data = {
        "data": [{
            userId: UID,
            plantId: id,
            datePlanted: date
        }]
    }
    console.log(data.data);
    const response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(data),
      });

      console.log(response);

      tableCheck();
      displayUserPlants(info);
      

}
async function remPlant(id)
{
    let delId = null;

    userData.forEach((uId)=> {
        if (uId.plantId===id){
            delId = uId.id;
        }
    });

    url = uHost(null)
    const data = 
   {
        "data": [{
            id: delId
        }]
    }
    const response = await fetch(url, {
        method: "DELETE",
        body: JSON.stringify(data),
      });

      tableCheck();
      displayUserPlants(info);
    
}

function tableCheck()
{
    const pTable = document.getElementById("uTable"); // check for table
    const noFou = document.getElementById("noUFoundDiv");
    if(pTable)
    {
        pTable.parentNode.removeChild(pTable); // delete existing table
    }
    if(noFou)
    {
        noFou.parentNode.removeChild(noFou); // delete not found message
    }
}

function allowAdd(){

    let addElements = document.getElementsByClassName("addButton");
    
    console.log(addElements);
    for (var i=0; i< addElements.length; i++) {
        addElements[i].addEventListener("click", (e) => {

          //  if (!userData) return; // no userdata so back out without trying to do anything
            e.preventDefault(); // prevent default error
            uPlantList.length = 0; // reset plantlist
            tableCheck();
            
            addPlant(e.target.id);
    
        }); 
    }
}

function removePlant(){
    let remElements = document.getElementsByClassName("remButton");

    for (var i=0; i<remElements.length; i++) {
        remElements[i].addEventListener("click", (e) => {

            e.preventDefault(); // prevent default error
            uPlantList.length = 0; // reset plantlist
            tableCheck();
            
            remPlant(e.target.id); // get user value
    
        }); 
    }
}

document.getElementById("Tbutton").addEventListener('click', () => {
        console.log("worked");
        
        displayUserPlants(info);
});



export{allowAdd, displayUserPlants}



