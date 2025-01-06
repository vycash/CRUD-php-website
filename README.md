## this is a simple crud website made using php storing and retrieving data of animals from a mysql Database developped in the context of a university assignement.

this project was built using the MVCR architecture (model,vue,controller,router) to ensure modularity and make it easier to maintain and update.  
- you will need to modify the mysql_config.php with the infos needed (connection details, username,passwd,hostname etc..).
- you can create a compatible table in you db using the sql file.
- next you can host the code on a plateform of your liking and it should e all set.
- after completing the steps above the api too should be functional.

#### the api calls must be made with the variables:
- api.php?collection=animaux : to get the full list of the animals (only name and id )
- api.php?collection=animaux&id=1 : to get the full info about one animal with the id 1 
