---> /plantingzone <---

By default /plantingzone requires no URL params. This will return all plantingzones in the table. There is no concern with this query as it only returns 9 results.

Example output:
[
    {
        "id": "42889359-aaf4-11ed-99d2-244bfe7dd4fe",
        "number": "3"
    },
  .....
    {
        "id": "428894a9-aaf4-11ed-99d2-244bfe7dd4fe",
        "number": "11"
    },
]

This is a small and uncomplicated table. Therefore only id and number can be used as URL params. When requesting for a specific zone, all zip codes within that zone are also directly return as a child object. This can be used or ignored. If only one zone is desired request the entire table and use the one you are looking for.

Allowed URL params: id, number

URL example: /plantginzone?number=11

Example output:
[
    {
        "id": "428894a9-aaf4-11ed-99d2-244bfe7dd4fe",
        "number": "11",
        "zipcodes": [
            {
                "id": "46b98344-aaf4-11ed-99d2-244bfe7dd4fe",
                "zipCode": "33001",
                "plantingZoneId": "428894a9-aaf4-11ed-99d2-244bfe7dd4fe",
                "plantingZoneSub": "a",
                "tempRange": "40 to 45"
            },
            {
                "id": "46b992d5-aaf4-11ed-99d2-244bfe7dd4fe",
                "zipCode": "33036",
                "plantingZoneId": "428894a9-aaf4-11ed-99d2-244bfe7dd4fe",
                "plantingZoneSub": "a",
                "tempRange": "40 to 45"
            }
        ]
    }
]