<?php
/*
 * Author: Daniel Dietrich
 * This file is to test the authenticateLogin.php file.
 * To run these tests, access this page using a web browser. 
 * All tests will be run automatically and results will be displayed in browser.
 */

define('MyConst', TRUE);

//Test with Invalid Credentials.?>
<h1>Invalid Credential (IC) Test:<br></h1>
<p>This is the authenticateLogin.php test with Invalid Credentials. The test is passed if the Page is directed to the login.html page with the invalid credential message.
    <br> Any other result for invalid credentials fails the test.</p>
<form id="login-form" method="post" action="../1_code/API/api/user/authenticateLogin.php">
            <div class="input-field">
                    
                    <input name ="login-username" id="login-username" type="hidden" required value="invalidUsername">
            </div>
            <div class="input-field">
                    
                    <input name ="login-password" type="hidden" id="login-password" required value="invalidPassword">
            </div>
            <div>
                    <button class ="signupbtn" id="signupbtn" value="Submit">Run IC Test</button>
                </p>
            </div>
    </form>
<h1>Valid Credential (VC) Test:<br></h1>
<p>This is the authenticateLogin.php test with Valid Credentials. The test is passed if the Page is directed to the userinfo.html page.
    <br> Any other result for valid credentials fails the test.</p>
<form id="login-form" method="post" action="../1_code/API/api/user/authenticateLogin.php">
            <div class="input-field">
                    
                    <input name ="login-username" id="login-username" type="hidden" required value="testerUser1">
            </div>
            <div class="input-field">
                  
                    <input name ="login-password" type="hidden" id="login-password" required value="TestPassword121212">
            </div>
            <div>
                    <button class ="signupbtn" id="signupbtn" value="Submit">Run VC Test</button>
                </p>
            </div>
    </form>
