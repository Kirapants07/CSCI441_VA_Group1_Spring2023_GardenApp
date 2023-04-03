---> /plant <---

By default /plant requires no URL params. This could potentially be a large query based on the amount of plants. However, with no URL params provided this request passes the query directly back to the requestor with no formatting. Quickest way to get a list of ALL plansts supported by the database. List is ordered by name automatically.

Example output:
[
    {
        "id": "4c6f706a-aaf4-11ed-99d2-244bfe7dd4fe",
        "name": "blackberry",
        "pluralName": "blackberries",
        "type": "fruit",
        "spacing": "3-6 feet (depending on variety)",
        "germinationInformation": "3 to 5 months",
        "harvestInformation": "Start to ripen in July and August"
    },
    {
        "id": "4c6f5f4a-aaf4-11ed-99d2-244bfe7dd4fe",
        "name": "carrot",
        "pluralName": "carrots",
        "type": "vegetable",
        "spacing": "2-3 inches",
        "germinationInformation": "7 to 21 days",
        "harvestInformation": "50 to 60 days"
    }
]

Plant table is the central hub of the database and has two connecting tables. plantinginstructions and plantingrelationship.

Allowed URL params: id, name, pluralname, type
Optional params when using name: zoneid, zonenum, zonesub (See explanation below*)

There are a few options to take into account when making requests to this table. You can provide type as a URL param, if doing so ALL other params are ignored and you will receive a list of plants of the given type.

URL example: /plant?type=fruit

Example output:
[
    {
        "id": "4c6f706a-aaf4-11ed-99d2-244bfe7dd4fe",
        "name": "blackberry",
        "pluralName": "blackberries",
        "type": "fruit",
        "spacing": "3-6 feet (depending on variety)",
        "germinationInformation": "3 to 5 months",
        "harvestInformation": "Start to ripen in July and August"
    }
]

The other option is to provide the id or name of the plant you are specifically searching for. This will return the single plant object and two child JSON lists. 1. plantingrelationships and 2. planting instructions

Note: name can be searched by either singluar OR plural. Use name or pluralname for this use.

*To allow for more specific data return, you may also provide 'zoneid' or 'zonenum' when searching for a specific plant. This will return the planting instructions ONLY for the zone specified and ignore others. Additionally, this will provide all instructions for each sub zone, this can also be specified as 'zonesub'

URL example: /plant?name=carrot

Example output:
Same as below, but with ALL planting instructions for ALL zones.


URL example: /plant?name=carrot&zonenum=11&zonesub=a

Example output:
[
    {
        "id": "4c6f5f4a-aaf4-11ed-99d2-244bfe7dd4fe",
        "name": "carrot",
        "pluralName": "carrots",
        "type": "vegetable",
        "spacing": "2-3 inches",
        "germinationInformation": "7 to 21 days",
        "harvestInformation": "50 to 60 days",
        "plantinginstructions": [
            {
                "id": "4c894132-aaf4-11ed-99d2-244bfe7dd4fe",
                "plantId": "4c6f5f4a-aaf4-11ed-99d2-244bfe7dd4fe",
                "zoneId": "428894a9-aaf4-11ed-99d2-244bfe7dd4fe",
                "plantingZoneSub": "a",
                "season": "fall",
                "plantingType": "direct sow",
                "startDate": "1-Oct",
                "endDate": "30-Nov"
            },
          a.....
            {
                "id": "4c8a86dc-aaf4-11ed-99d2-244bfe7dd4fe",
                "plantId": "4c6f7098-aaf4-11ed-99d2-244bfe7dd4fe",
                "zoneId": "428894a9-aaf4-11ed-99d2-244bfe7dd4fe",
                "plantingZoneSub": "a",
                "season": "spring",
                "plantingType": "transplant",
                "startDate": "1-Apr",
                "endDate": "30-Apr"
            }
        ],
        "growingrelationships": [
            {
                "id": "4c717fad-aaf4-11ed-99d2-244bfe7dd4fe",
                "plantIdOne": "4c6f5f4a-aaf4-11ed-99d2-244bfe7dd4fe",
                "plantNameOne": "carrot",
                "plantIdTwo": "4c6f70bd-aaf4-11ed-99d2-244bfe7dd4fe",
                "plantNameTwo": "radish",
                "relationship": "avoid"
            }
        ]
    }
]