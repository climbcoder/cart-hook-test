## Basic CS

A) The first migrations of the repository are the ones relative to the NBA database (except the first twos that are the default from Laravel)

Note:
- Added index to columns game date and team name in order to speed up the game results when filtered by date and team name. Also added indexes to foreign keys involved in the query.
- Added index to column player name in order to speed up the query of player statistics when filtered by players name.

B) You can find the bash script [here](/script.sh)

Note:
- To run the script on a specific directory type ./script.sh <directory-name> otherwise will run on the current directory
- I've added some sub-folders and files to run the script on directory [/exampleScript](/exampleScript)

C) and D)

You can find the class with the methods for the two assignments [here](/app/Helpers/Sorter.php)

You can find relative tests [here](/tests/Unit/SorterTest.php)

There are comments that explain the methods both in class and test

## Advanced/Practical

a. )

#### First part

All the api endpoints relative to the first part of the assignment are under `api/v1` route.
Same for Controllers that are under namespace `App\Http\Controllers\V1`
These endpoints retrieve elements directly from placeholder API without any optimization.

Relative **tests** can be found in [tests/Feature/V1](tests/Feature/V1) folder.

#### Second part

All the api endpoints relative to the second part of the assignment are under `api/v2` route.
Same for Controllers that are under namespace `App\Http\Controllers\V2`
These endpoints retrieve elements from placeholder API only if the elements are not yet created.

The migrations for the tables of the Models have indexes in the field used for the queries (foreign key attributes and the string filters).

Possible improvements can be the usage of ElasticSearch in order to store data from placeholder directly there and do not have to store them in the database and have to do mappings with DB attributes.
Another improvement could be to create a night cron Job that import data in order to not have to run the query to placeholder API in the first place when the data are not present.

Relative **tests** can be found in [tests/Feature/V2](/tests/Feature/V2) folder.

b. ) This README is the page with the explanations
