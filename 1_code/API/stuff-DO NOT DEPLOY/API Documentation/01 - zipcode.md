---> /zipcode <---

By default /zipcode requires no URL params. This will automatically return ALL 40,534 zip codes in the continental United States. This is uncommonly needed and is a large transfer size (6.39 MB). However to note, since the API simply passes the query directly to the requester with no custom formatting, this is a quick operation.

Example output:
[
    {
        "id": "44456067-aaf4-11ed-99d2-244bfe7dd4fe",
        "zipCode": "10001",
        "plantingZoneId": "4288945f-aaf4-11ed-99d2-244bfe7dd4fe",
        "plantingZoneSub": "b",
        "tempRange": "5 to 10"
    },
    {
        "id": "444560d6-aaf4-11ed-99d2-244bfe7dd4fe",
        "zipCode": "10002",
        "plantingZoneId": "4288945f-aaf4-11ed-99d2-244bfe7dd4fe",
        "plantingZoneSub": "b",
        "tempRange": "5 to 10"
    }
]

Only two URL parameters are permitted for this endpoint, zipcode and id. The user can specify a specific zipcode or the id. When doing so the API will return that one zip code and the related plantingzone id/number.

Allowed URL params: id, zipcode

URL example: /zipcode?zipcode=27357

Example output:
[
    {
        "id": "46b43510-aaf4-11ed-99d2-244bfe7dd4fe",
        "zipCode": "27357",
        "plantingZone": [
            {
                "id": "4288945f-aaf4-11ed-99d2-244bfe7dd4fe",
                "number": "7"
            }
        ],
        "plantingZoneSub": "b",
        "tempRange": "5 to 10"
    }
]