//Todd M. Wood
//Search testing - Testing for data functions to make sure they are operating correctly
//4-4-2023
import host from "../1_code/Website/plantjs/hostUrl.js";
import getPlants from "../1_code/Website/plantjs/getPlants.js";

//values for testing
const pname = null;
const type = null;
const zone = null;
const plantName1 = 'carrot';
const plantName2 = 'blackberry';
const plantName3 = 'Radish';
const plantName4 = 'kkjnu';
const plantType1 = 'vegetable';
const plantType2 = 'gerbil';
const plantType3 = 'fruit';
const plantType4 = 'herb';



// wait for load of page
window.onload = init;

//initiate button 
function init () {
    let bttn = document.getElementById("testing");
    bttn.addEventListener("click", runTest); // run test
}

//test for plants if successful will display "Search Results" if Fail will display "No plants were Found"
async function runTest() {
    urlBuild(type, pname, zone);

    await searchPlants(plantName1, 8);
    await searchPlants(plantName2, 8);
    await searchPlants(plantName3, 8);
    await searchPlants(plantName4, 8);
    await searchPlants(plantType1, 8);
    await searchPlants(plantType2, 8); 
    await searchPlants(plantType3, 8);
    await searchPlants(plantType4, 8);
  
}

//build url using variables  success will show url
function urlBuild (type, name, zone){
        let main = document.querySelector('main');
        
        //testing url build expected result properly built url
        //call with nothing
        let result = host(name, type, zone);// no values
        console.log(result);
        var post = document.createElement("p");
        post.innerText = `test #1: ${result}`;
        main.appendChild(post);

        // call with just name
        name = 'carrot';
        result = host(name, type, zone); // name value
        console.log(result);
        var post = document.createElement("p");
        post.innerText = `test #2: ${result}`;
        main.appendChild(post);
    
        // call with just type
        name = null;
        type = 'fruit';
        result = host(name, type, zone); //type value
        console.log(result);
        var post = document.createElement("p");
        post.innerText = `test #3: ${result}`;
        main.appendChild(post);

        // call with name and zone
        name = 'carrot';
        zone = 8;
        result = host(name, type, zone); // name zone value
        console.log(result);
        var post = document.createElement("p");
        post.innerText = `test #4: ${result}`;
        main.appendChild(post);

    }


// call search functions
async function searchPlants(plant, zone){
        await getPlants(plant,zone);
}



