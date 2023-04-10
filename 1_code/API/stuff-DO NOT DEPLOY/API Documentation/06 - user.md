---> /user <---
GET - POST - PUT - DELETE

GET request:
 /user GET only allows username to be provided to get user information and data. All user info and saved data is returned. This request only returns one user, there is no general user pull for all data.

 Exmaple:
 [
    {
        "id": "508715b4-cc3b-11ed-9782-244bfe7dd4fe",
        "userName": "testuser",
        "email": "testuser@plant.com",
        "firstName": "test",
        "lastName": "user",
        "fullName": "test user",
        "isRemovedFlag": null,
        "hasAccessFlag": "1",
        "isAdminFlag": "0",
        "createdDate": "2023-03-26 21:04:15",
        "lastModifiedDate": "2023-03-27 03:03:27"
    }
]

POST request:
Creating a user has required paramters that MUST be provided to create a new user. Only ONE user may be created at a time.

They are: "userName", "passwordHash", "email", "firstName", "lastName", "fullName", "hasAccessFlag"
Optional: "isRemovedFlag"

If any required paramters are missing the API will return a 400 Bad Request error and a generic messsage.

!!! >>> NOTE: PASSWORDS SHOULD BE ENCRYPTED WITH BASE 64 ENCODING BEFORE PASSING THROUGH THIS CALL <<< !!!

Example input:
{
    "data" : [
        {
            "userName": "testerUser1",
            "passwordHash": "TestPassword121212",
            "email": "testeruserer@gmail.com",
            "firstName": "Tester",
            "lastName": "Userer",
            "fullName": "Tester Userer",
            "hasAccessFlag": "1",
            "isRemovedFlag": "0"
        }
    ]
}   

Example output:
SUCCESSFUL Creation: (201)
[
    {
        "success": "true",
        "message": "Successfully created users",
        "data": {
            "id": "af91bf21-cf52-11ed-9782-244bfe7dd4fe",
            "userName": "testerUser1",
            "passwordHash": "TestPassword121212",
            "email": "testeruserer@gmail.com",
            "firstName": "Tester",
            "lastName": "Userer",
            "fullName": "Tester Userer",
            "hasAccessFlag": "1",
            "isRemovedFlag": "0"
        }
    }
]

Failed Creation: (400)
User already exists:
[
    {
        "success": "false",
        "message": "User already exists. Cannot create duplicate users."
    }
]
Missing variables:
[
    {
        "success": "false",
        "message": "Incorrect provided paramters! For users REQUIRED inputs: userName, passwordHash, email, firstName, lastName, fullName, hasAccessFlag and OPTIONAL inputs: isRemovedFlag",
        "data": null
    }
]


PUT request:
At minimum update requests MUST have the id present to write updates to the database. For update ALL over variables are optional and should only be provided if there is an update.

Example input:
{
    "data" : [
        {
            "id": "0befb235-cf54-11ed-9782-244bfe7dd4fe",
            "userName": "testerUser12UPDA1TE"
        }
    ]
}  

Example output:
Note: failure messages mirror the POST requests.

Success: (201)
[
    {
        "success": "true",
        "message": "Successfully updated users",
        "data": {
            "id": "0befb235-cf54-11ed-9782-244bfe7dd4fe",
            "userName": "testerUser12UPDA1TE"
        }
    }
]

DELETE request:
Note: users are never deleted and PUT should be used to update the users status
isRemovedFlag and hasAccessFlag set to 0 instead of 1 / NULL(default)