//Gavin Cyr
//Search testing - Testing for data functions to make sure they are operating correctly
//4-5-2023
import getZipcode from "../1_code/Website/zipcodejs/getZipcode.js";

//values for testing
const zipcode = null;
const zipcode1 = '00000';
const zipcode2 = '66938';



// wait for load of page
window.onload = init;

//initiate button 
function init () {
    let bttn = document.getElementById("testing");
    bttn.addEventListener("click", runTest); // run test
}

//test for zipcode if successful will display "Search Results" if Fail will display "No Zipcode was found" or "Please Enter a Five Digit Zipcode"
async function runTest() {
    urlBuild(zipcode);
    await searchZipcode(zipcode);
    await searchZipcode(zipcode1);
    await searchZipcode(zipcode2);
}

//build url using variables  success will show url
function urlBuild (zipcode){
        let main = document.querySelector('main');
        
        //testing url build expected result properly built url
        //call with nothing
        let result = `http://localhost/CSCI441_VA_Group1_Spring2023_GardenApp/1_code/API/api/zipcode/?zipcode=${zipcode}`; // no values
        console.log(result);
        var post = document.createElement("z");
        post.innerText = `\nTest #1: ${result}`;
        main.appendChild(post);

        // call non valid zipcode
        result = `http://localhost/CSCI441_VA_Group1_Spring2023_GardenApp/1_code/API/api/zipcode/?zipcode=${zipcode1}`; // not a valid zipcode
        console.log(result);
        var post = document.createElement("z");
        post.innerText = `\nTest #2: ${result}`;
        main.appendChild(post);

        // call valid zipcode
        result = `http://localhost/CSCI441_VA_Group1_Spring2023_GardenApp/1_code/API/api/zipcode/?zipcode=${zipcode2}`; // valid zipcode
        console.log(result);
        var post = document.createElement("z");
        post.innerText = `\nTest #3: ${result}`;
        main.appendChild(post);
    }


// call search functions
async function searchZipcode(zipcode){
        await getZipcode(zipcode);
}

