# Finizens' FullStack Challenge

## Installation

Set the BD data in .env file
   ```bash
   DATABASE_URL=mysql://root:@localhost:3306/docker_symfony4
   ```

Install the depencies
   
   ```bash
   composer install
   ```
Create the DB
   ```bash
  doctrine:database:create
   ```
Add sample Data 
   
   ```bash
   doctrine:fixtures:load
   ```
   

## Usage

Main input HTTP petitions:

Create a buy order:
```bash
   PUT /portfolio HTTP/1.1
   Host: localDomain.local
   Content-Type: application/json
   
   {
       "id": 1,
       "portfolio": 1,
       "allocation": 3,
       "shares": 4
   }
   ```
   Create a sell order:
   ```bash
   PUT /sell HTTP/1.1
   Host: fullstacktest.local
   Content-Type: application/json
   
   {
     "id": 1,
     "portfolio": 1,
     "allocation": 3,
     "shares": 4
   }
   ```
## License
[MIT](https://choosealicense.com/licenses/mit/)