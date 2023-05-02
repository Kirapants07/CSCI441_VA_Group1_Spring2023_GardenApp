<?php
/*
 * Author: Daniel Dietrich
 * This file is to test the signup.php file and the integation of Account Creation with User Authentication.
 * To run these tests, access this page using a web browser. 
 * All tests will be run by selecting the submit button and results will be displayed in browser.
 */

define('MyConst', TRUE);

//Test with Invalid Credentials.?>
<h1>Account Creation (Sign-up) Test:<br></h1>
<p>This is the signup.php test. This test should be ran twice.
    <br> 1st Run: The test is passed if the if a user account with the username "newtestuser" is created and signed in.
    <br> --- This tests the ingegration of the Account Creation feature with the User Authentication feature.
    <br><br> 2nd Run: The test is passed if the Page is directed to the signup.html page with the taken username message.
    <br> Any other result for a given test fails.</p>
<form id="login-form" method="post" action="../1_code/API/api/user/signup.php">
            <div class="input-field">
                    
                    <input name ="login-username" id="login-username" type="hidden" required value="invalidUsername">
            </div>
            <div class="input-field">
                    
                    <input name ="login-password" type="hidden" id="login-password" required value="invalidPassword">
            </div>
            <div class="input-field">
                <input name="signup-firstname" type="hidden" id="signup-firstname"  required value="New">
            </div>
            <div class="input-field">
                <input type="hidden" name="signup-lastname" id="signup-lastname" required value="User">
            </div>
            <div class="input-field">
                <input type="hidden" name="signup-username" id="signup-username" required value="newtestuser">
            </div>
            <div class="input-field">
            <input type="hidden" name="signup-email" id="signup-email" required value="newtest@mail.com">
            </div>
            <div class="input-field">
                    <input type="hidden" name="signup-password" id="signup-password" required value="TestPass12321">
            </div>
            <div>
                    <button class ="signupbtn" id="signupbtn" value="Submit">Run Test</button>
                </p>
            </div>
    </form>
