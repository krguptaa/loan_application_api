## Laravel Admin Panel (Current: Laravel 7.*)

This app is a sample api interaction with example of Loan Process. We have created several api such Users Login, Signup, Get Loan Details, Get all Loans, Apply Loan, Approve Loan and Pay EMIs etc. We have used JWT for authentication and authorization. We have put a lot of work into it and we hope it serves you well and give a some idea about API!
### Setup

Clone the repo and follow below steps.
1. Run `composer install`
2. Copy `.env.example` to `.env` Example for linux users : `cp .env.example .env`
3. Set valid database credentials of env variables `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`
4. Run `php artisan key:generate` to generate application key
5. Run `php artisan migrate`
6. Run `php artisan jwt:secret`
7. Run `php artisan db:seed` to seed your database

Thats it... Run the command `php artisan serve` and cheers, you are good to go with your application.

### **List of APIs**

PN: My local server was http://127.0.0.1:9090 You may change the settings as per you laravel environment

1. POST - http://127.0.0.1:8000/api/v1/users ( Pre Login )
2. POST - http://127.0.0.1:8000/api/v1/auth/login ( Pre Login )
3. POST - http://127.0.0.1:8000/api/v1/loans/apply ( Post Login )
4. POST - http://127.0.0.1:8000/api/v1/loans/approve ( Post Login )
5. POST - http://127.0.0.1:8000/api/v1/loans/payloan ( Post Login )
6  GET -  http://127.0.0.1:8000/api/v1/loans ( Post Login )
7. GET -  http://127.0.0.1:8000/api/v1/loans/1 ( Post Login )

### Demo Credentials
---
*Make sure you have run the command `php artisan db:seed --class UserTableSeeder` before you use these credentials.*

**User:** admin@admin.com\
**Password:** 123456

## Contribution
Feel free to create any pull requests for the project. For proposing any new changes or features you want to add to the project, you can send us an email at following addresses.

    1. Kamlesh Gupta - webworldgk@gmail.com
    




