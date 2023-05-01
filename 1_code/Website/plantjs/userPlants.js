//userPlants
//Todd M. Wood
//Restores and saves users plants

import Plant from "./plantClass.js";
import {uHost, host} from './hostUrl.js';

let url = null;

const uPlantList = [];
let userData = null;
let info = null;
//Function to fetch and get plants


async function getUserInfo(UID) {
    // build the url
    let url = uHost(UID);
    let userResp = await fetch(url);

    userData = await userResp.json(); // get the user data
   // if no user data
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
    // if data found call to get user plants
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
        const newPlant = new Plant(temp.id,temp.name,temp.type,userData[i].datePlanted,temp.spacing,temp.germinationInformation,temp.harvestInformation,temp.plantingInstructions,userData[i].id);
        uPlantList.push(newPlant);   
               
    }
    // display users plants
    const div = document.createElement("div");
    div.setAttribute("id", "noUFoundDiv");
    const success = document.createTextNode("Your plants:");
    div.append(success);
    let main = document.getElementById('myPlants');
    main.append(div);    

}

// Place the plants onto the website
async function displayUserPlants (UID) {
    // make sure the user is logged in
    if (!info){
        window.confirm("You need to be logged in to user this feature!");
        info = null;
        return;
    }
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

    removePlant(); // fire removeplant listener
    updateDate(); // fire update plant listener
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
    tDate.textContent = "Date Planted";
    let tSpacing = document.createElement("th");
    tSpacing.textContent = "Spacing";
    let tGerm = document.createElement("th");
    tGerm.textContent = "Germination";
    let tHarv = document.createElement("th");
    tHarv.textContent = "Harvest";
    let btn = document.createElement("th");
    btn.textContent = "Remove";
    let ubtn = document.createElement("th");
    ubtn.textContent = "Update Date";

    //append header elements
    title.appendChild(tName);
    title.appendChild(tType);
    title.appendChild(tDate);
    title.appendChild(tSpacing);
    title.appendChild(tGerm);
    title.appendChild(tHarv);
    title.appendChild(btn);
    title.appendChild(ubtn);


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

        let upRow = document.createElement("td");
        upRow.innerHTML = (`
            <button alt="update"> 
                <span id="${plant.getpID()}" class="udButton material-icons md-36">
                    update
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
        newRow.appendChild(upRow);

    }
    return fragment;
}

//adds a plant
async function addPlant(id,date='0000-00-00')
{
    // check for an ID
    let UID = null;
    if (!userData || userData.message) UID = info;
    else UID = userData[0].userId;
    // get the house
    url = uHost(null);
    // create data element
    const data = {
        "data": [{
            userId: UID,
            plantId: id,
            datePlanted: date
        }]
    }
    // send data to api
    const response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(data),
      });

    

      tableCheck(); // clear the table
      displayUserPlants(info); // repopulate the table
      

}
// updates the plant date
async function updatePlant(iD,date)
{
    // get the url
    url = uHost(null);
    // package data
    const data = {
        "data": [{
            id: iD,
            datePlanted: date
        }]
    }
    
    // send data to api
    const response = await fetch(url, {
        method: "PUT",
        body: JSON.stringify(data),
      });



      tableCheck(); // clear the table
      displayUserPlants(info); // repop the table
      

}
// remove a plant
async function remPlant(id)
{
    // create a variable for deleted id
    let delId = null;

    // find the id in the list
    userData.forEach((uId)=> {
        if (uId.plantId===id){
            delId = uId.id;
        }
    });
    // get url
    url = uHost(null)
    // set data
    const data = 
   {
        "data": [{
            id: delId
        }]
    }
    // send to api
    const response = await fetch(url, {
        method: "DELETE",
        body: JSON.stringify(data),
      });

      tableCheck(); // clear table
      displayUserPlants(info); // repop table

    
}

// clearing function for table
function tableCheck()
{
    uPlantList.length = 0;
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

// event lister for add buttons
function allowAdd(){
    // grab the add buttons
    let addElements = document.getElementsByClassName("addButton material-icons md-36");
    // set listerns for all add buttons
    for (var i=0; i< addElements.length; i++) {
        addElements[i].addEventListener("click", (e) => {
        
        // don't allow a non logged in user to use add
         if (!document.cookie) {
            window.confirm("You need to be logged in to use this feature");
            return;
          } // no userdata so back out without trying to do anything
            e.preventDefault(); // prevent default error
            uPlantList.length = 0; // reset plantlist
            
            // grab the ID and date
            let todayDate = new Date().toISOString().slice(0, 10);
            addPlant(e.target.id, todayDate);
    
        }); 
        
    }

}
// check the date and set it for storage
function checkDate(date) {
    
    // regex date check
    const check = /^\d{2}\-|\/\d{2}\-|\/\d{4}$/;
     
    // make sure the date is in the format needed
    const result = check.test(date);
    if (!result)
    {
        window.confirm("The date format is invalid.  It must be MM-DD-YYYY or MM/DD/YYYY");
        return 0;
    }
    // refactor the date for storage
    let splitDate = date.split(""); 
    const newDate = `${splitDate[6]}${splitDate[7]}${splitDate[8]}${splitDate[9]}-${splitDate[0]}${splitDate[1]}-${splitDate[3]}${splitDate[4]}`;
    
    return newDate; // send the refactored date to the calling function
}

//update with a new date event listener
function updateDate(){

    // grab all update icons
    let upDateElements = document.getElementsByClassName("udButton material-icons md-36");

    // set an event listener
    for (var i=0; i< upDateElements.length; i++) {
        upDateElements[i].addEventListener("click", (e) => {

            e.preventDefault(); // prevent default error
            const inDate = window.prompt("Add Your New Date", "MM-DD-YYYY"); // prompt for a date
            
            const date = checkDate(inDate); // check the date
            if (!date) return;
            // send the id and the daet    
            updatePlant(e.target.id, date);
        }); 
    }
}

// remove plant listener
function removePlant(){
    // grab all remove buttons
    let remElements = document.getElementsByClassName("remButton material-icons md-36");

    // set the listener for each button
    for (var i=0; i<remElements.length; i++) {
        remElements[i].addEventListener("click", (e) => {

            e.preventDefault(); // prevent default error
            uPlantList.length = 0; // reset plantlist
            
            remPlant(e.target.id); // get user value and send to the remove functions
    
        }); 
    }
    
}
// add listener for My plants selection
document.getElementById("Tbutton").addEventListener('click', () => {   
        // Make sure the user is logged in. If not message and return
        if (!document.cookie){
            window.confirm("You need to be logged in to use this feature!");
            info = null;
            return;
        }
        // if logged in get the user ID by splicing off the cookie
        const idCookie = document.cookie;
        let splitCookie = idCookie.split(""); 
        let sliceID = splitCookie.slice(splitCookie.length-36,splitCookie.length);
        info = sliceID.join("");
        
        tableCheck();  // clear any tables  
        displayUserPlants(info); // display the users plants
});



export{allowAdd, displayUserPlants} // export



