
### About the Solution
- This code uses google geolocation service
- Solution is build using Laravel Framework 9.52.15
- Code contains an API and a Custom command 
- Code will find Lat and Long for the provided Source 
- Code will get data  of destinations from the helper data file
- Code will find Lat and Long for the provided destination
- Then it will output calculated distance  between two points i.e. source and every distance
- It will generate a distance.csv file to give the required output in expected format

<details>

<summary> Steps for Installation and running command </summary>

### Git clone
git clone https://github.com/sinhakgaurav/eastern_distance_command.git

### install dependency
composer install


### command to run
```
php .\artisan calculate:distances {source} 
example:
php .\artisan calculate:distances  "Adchieve HQ - Sint Janssingel 92, 5211 DA 's-Hertogenbosch, The Netherlands"
```
### storage for the CSV created
CSV created will be located as /storage/distance.csv
</details>


<details>

<summary>Steps for Installation and running API</summary>

### Git clone
git clone https://github.com/sinhakgaurav/eastern_distance_command.git

### install dependency
composer install


### command to run
php .\artisan serve {source} 

### Run the API
- Data to use (RAW data)
```
{
    "source": "Adchieve HQ - Sint Janssingel 92, 5211 DA 's-Hertogenbosch, The Netherlands",
    "destinations": [
        "Eastern Enterprise B.V. - Deldenerstraat 70, 7551AH Hengelo, The Netherlands",
        "Eastern Enterprise - 46/1 Office no 1 Ground Floor , Dada House , Inside dada silk mills compound, Udhana Main Rd,near Chhaydo Hospital, Surat, 394210, India",
        "Adchieve Rotterdam - Weena 505, 3013 AL Rotterdam, The Netherlands",
        "Sherlock Holmes - 221B Baker St., London, United Kingdom",
        "The White House - 1600 Pennsylvania Avenue, Washington, D.C., USA",
        "The Empire State Building - 350 Fifth Avenue, New York City, NY 10118",
        "The Pope - Saint Martha House, 00120 Citta del Vaticano, Vatican City",
        "Neverland - 5225 Figueroa Mountain Road, Los Olivos, Calif. 93441, USA"
    ]
}
```
- POST to below URL with the data using Postman or any other tool
```http://127.0.0.1:8000/api/calculate-distances``` 
### storage for the CSV created
CSV created will be located as /storage/distance.csv
</details>