---> /plantgrowingrelationship <---

By default /plantgrowingrelationship requires no URL params. This table contains direct relationships between plants that either help or are to be avoided.

Note: in the below queries plantName(s) have been joined in from their parent tables to make the data more legible.

Allowed URL params: id, name
Optional params with special functionality: plant1Name, plant2Name (case sensitive)

Note: Order of precendence for API querires is as listed in order of the above allowed params. Left to right.
id->name->plant1 and 2 name
Example: if you provide both id and name, name will be ignored.

Having no params will return ALL plant relationships in the database and will be written to include the plant name along with the plant id. Provide a more specific query to get more plant data.

URL example: /plantgrowingrelationship

Example output:
[
    {
        "id": "510202f3-ab01-11ed-99d2-244bfe7dd4fe",
        "plantIdOne": "510152af-ab01-11ed-99d2-244bfe7dd4fe",
        "plantNameOne": "cauliflower",
        "plantIdTwo": "5101533d-ab01-11ed-99d2-244bfe7dd4fe",
        "plantNameTwo": "spinach",
        "relationship": "helps"
    },
    {
        "id": "51021800-ab01-11ed-99d2-244bfe7dd4fe",
        "plantIdOne": "51014596-ab01-11ed-99d2-244bfe7dd4fe",
        "plantNameOne": "carrot",
        "plantIdTwo": "5101535c-ab01-11ed-99d2-244bfe7dd4fe",
        "plantNameTwo": "radish",
        "relationship": "avoid"
    }
]

You can provide either name or id as a param, but not both. If id is provied you will be returned a specific relationship within the table with specific plant data for each plant in the relationship.

Name can be used to search BOTH columns for any mention of the given plant and will return a report listing all relationships that plant exists in along with the name and id of the plant.

URL example: /plantgrowingrelationship?id=<UUID>

Example output:
[
    {
        "id": "510202f3-ab01-11ed-99d2-244bfe7dd4fe",
        "plantIdOne": "510152af-ab01-11ed-99d2-244bfe7dd4fe",
        "plantNameOne": "cauliflower",
        "plantIdTwo": "5101533d-ab01-11ed-99d2-244bfe7dd4fe",
        "plantNameTwo": "spinach",
        "relationship": "helps"
    }
]


URL example: /plantgrowingrelationship?name=carrot

Example output:
[
    {
        "id": "51021800-ab01-11ed-99d2-244bfe7dd4fe",
        "plantIdOne": "51014596-ab01-11ed-99d2-244bfe7dd4fe",
        "plantNameOne": "carrot",
        "plantIdTwo": "5101535c-ab01-11ed-99d2-244bfe7dd4fe",
        "plantNameTwo": "radish",
        "relationship": "avoid"
    }
]

Optional functionality exists to define specific relationships between two distinct plants. The URL params must be provided specifically as plant1Name, plant2Name (case sensitive). If this relationship exists the API will return data, otherwise a 404 response will be returned.

URL example: /plantgrowingrelationship?plant1Name=radish&plant2Name=carrot

Example output:
[
    {
        "id": "51021800-ab01-11ed-99d2-244bfe7dd4fe",
        "plantIdOne": "51014596-ab01-11ed-99d2-244bfe7dd4fe",
        "plantNameOne": "carrot",
        "plantIdTwo": "5101535c-ab01-11ed-99d2-244bfe7dd4fe",
        "plantNameTwo": "radish",
        "relationship": "avoid"
    }
]

If more specific plant data is needed, please use the /plant endpoint. This endpoint is only used to reflect all or specific relationships between companion plants.