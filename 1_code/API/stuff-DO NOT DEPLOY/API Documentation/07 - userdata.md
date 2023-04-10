---> /userdata <---
GET - POST - PUT - DELETE

Note: Error handling is the same as /user, please reference that documentation for failures of the below requests.

GET request:
/userdata GET only allows id to be provided as a URL param, this is the USER ID. This will return all saved planted plants and the plant date for that user.
/userdata?id=0befb235-cf54-11ed-9782-244bfe7dd4fe

Example:
[
    {
        "id": "637741dc-d34b-11ed-9782-244bfe7dd4fe",
        "userId": "0befb235-cf54-11ed-9782-244bfe7dd4fe",
        "plantId": "db362a9c-d345-11ed-9782-244bfe7dd4fe",
        "datePlanted": "2023-10-10"
    }
]

POST request:
Creating a userdata requires a plantid, userid and the planteddate. They all must be provided to create the instance.

If any required paramters are missing the API will return a 400 Bad Request error and a generic messsage.

Example Input:
{
    "data" : [
        {
            "userId": "0befb235-cf54-11ed-9782-244bfe7dd4fe",
            "plantId": "db362a9c-d345-11ed-9782-244bfe7dd4fe",
            "datePlanted": "2023-10-10"
        }
    ]
}   

Example output:
[
    {
        "success": "true",
        "message": "Successfully created userdata",
        "data": {
            "id": "b7749840-d7d8-11ed-9782-244bfe7dd4fe",
            "userId": "0befb235-cf54-11ed-9782-244bfe7dd4fe",
            "plantId": "db362a9c-d345-11ed-9782-244bfe7dd4fe",
            "datePlanted": "2023-10-10"
        }
    }
]

PUT request:
At minimum to update a userdata you must provide the unique id for that instance and whatever field you wish to update.

Example input:
{
    "data" : [
        {
            "id": "5b95d88e-d7d7-11ed-9782-244bfe7dd4fe",
            "datePlanted": "2023-10-12"
        }
    ]
}   

Example output:
[
    {
        "success": "true",
        "message": "Successfully updated userdata",
        "data": {
            "id": "5b95d88e-d7d7-11ed-9782-244bfe7dd4fe",
            "datePlanted": "2023-10-12"
        }
    }
]

DELETE request:
An instance id must be provided to delete a userdata, no other input will delete the instance. This works in a similar way to update, the HTTP request is just different.

Example input:
{
    "data" : [
        {
            "id": "b7749840-d7d8-11ed-9782-244bfe7dd4fe"
        }
    ]
}   

Example output:
[
    {
        "success": "true",
        "message": "Successfully deleted userdata",
        "data": {
            "id": "b7749840-d7d8-11ed-9782-244bfe7dd4fe"
        }
    }
]