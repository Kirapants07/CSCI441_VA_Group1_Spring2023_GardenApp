List of end points:
/zipcode
/plantingzone
/plant
/plantgrowingrelationship
/plantinginstructions

/user (GET, POST, PUT, DELETE)

Note: ALL endpoints return data as an array of JSON objects
Example:
[ {}. {} ]

Examples and instructions for endpoints can be found in associated files in this directory.

Most endpoints have some kind of restriction on the URL params that are available for query through the API. A list of allowed URL params per table can be found below. If a URL param is provided that is not recognized, the API will default to either no param or recognized params that are provided.