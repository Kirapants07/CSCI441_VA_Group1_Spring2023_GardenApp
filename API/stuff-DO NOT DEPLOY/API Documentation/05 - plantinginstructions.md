---> /plantinginstructions <---

By default /plantinginstructions requires no URL params. This table contains data specific to growing plants in a given zone and sub zone. This is a simple reference table, for more specific data based on region and specific plant /plant should be used.

Note: in the below queries zoneName and plantName have been joined in from their parent tables to make the data more legible.

Allowed URL params: id, zoneId, zoneNum

Having no params or params that do not function will return ALL plant growing instructions.

URL example: /plantinginstructions

Example output:
[
    {
        "id": "511998fa-ab01-11ed-99d2-244bfe7dd4fe",
        "plantId": "51015310-ab01-11ed-99d2-244bfe7dd4fe",
        "plantName": "blackberry",
        "zoneId": "46fadbbf-ab01-11ed-99d2-244bfe7dd4fe",
        "zoneNumber": "5",
        "plantingZoneSub": "a",
        "season": "spring",
        "plantingType": "transplant",
        "startDate": "15-May",
        "endDate": "15-May"
    },
  .....
    {
        "id": "511a49f9-ab01-11ed-99d2-244bfe7dd4fe",
        "plantId": "5101533d-ab01-11ed-99d2-244bfe7dd4fe",
        "plantName": "spinach",
        "zoneId": "46fadc3b-ab01-11ed-99d2-244bfe7dd4fe",
        "zoneNumber": "11",
        "plantingZoneSub": "b",
        "season": "sprint",
        "plantingType": "transplant",
        "startDate": "1-Apr",
        "endDate": "30-Apr"
    }
]

You can provide either id or zoneId as params for this endpoint. Providing id returns a single instruction as the id in the table pertains. Providing a zoneId will provide all instructions for all plants within the provided zone.

Note: more specific queries should be made from the /plant endpoint,

URL example: /plantgrowingrelationship?id=<UUID>

Example output:
[
    {
        "id": "511a49f9-ab01-11ed-99d2-244bfe7dd4fe",
        "plantId": "5101533d-ab01-11ed-99d2-244bfe7dd4fe",
        "plantName": "spinach",
        "zoneId": "46fadc3b-ab01-11ed-99d2-244bfe7dd4fe",
        "zoneNumber": "11",
        "plantingZoneSub": "b",
        "season": "sprint",
        "plantingType": "transplant",
        "startDate": "1-Apr",
        "endDate": "30-Apr"
    }
]


URL example: /plantgrowingrelationship?zoneId=<UUID> OR /plantgrowingrelationship?zoneNum=<zone number>

Example output:
[
    {
        "id": "51191db5-ab01-11ed-99d2-244bfe7dd4fe",
        "plantId": "51014596-ab01-11ed-99d2-244bfe7dd4fe",
        "plantName": "carrot",
        "zoneId": "46fadc3b-ab01-11ed-99d2-244bfe7dd4fe",
        "zoneNumber": "11",
        "plantingZoneSub": "a",
        "season": "fall",
        "plantingType": "transplant",
        "startDate": "1-Oct",
        "endDate": "30-Nov"
    },
  .....
    {
        "id": "511a49f9-ab01-11ed-99d2-244bfe7dd4fe",
        "plantId": "5101533d-ab01-11ed-99d2-244bfe7dd4fe",
        "plantName": "spinach",
        "zoneId": "46fadc3b-ab01-11ed-99d2-244bfe7dd4fe",
        "zoneNumber": "11",
        "plantingZoneSub": "b",
        "season": "sprint",
        "plantingType": "transplant",
        "startDate": "1-Apr",
        "endDate": "30-Apr"
    }
]