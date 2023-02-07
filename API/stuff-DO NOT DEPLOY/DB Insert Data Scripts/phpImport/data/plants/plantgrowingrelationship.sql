INSERT plantgrowingrelationship  
(id, plantIdOne, plantIdTwo, relationship)  
VALUES  
(uuid(), (SELECT id from plant WHERE name ='cauliflower'),(SELECT id from plant WHERE name ='spinach'),'helps'),
(uuid(), (SELECT id from plant WHERE name ='carrot'),(SELECT id from plant WHERE name ='radish'),'avoid');