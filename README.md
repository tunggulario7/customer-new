# Customer Data
## Install the Application

Run this command from the directory in which you want to install your Customer Application. You will require PHP 7.3 or newer.

```bash
composer install
```

After finish running composer, you can run docker using this command :
```bash
docker-compose up -d
```

## Url for POST Customer Data :
http://localhost:8080/customer

### Json Body Example for POST Customer Data :

{
"name": "Tunggul Ario",
"ktp": 123456789,
"loanAmount": 5000,
"loanPeriod": 12,
"loanPurpose": "vacation",
"dateOfBirth": "1992-12-23",
"sex": "Male"
}