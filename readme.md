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
8. Run `php artisan config:clear` and `php artisan cache:clear` to Clear Cache and Config

Thats it... Run the command `php artisan serve` and cheers, you are good to go with your application.

### **List of APIs**

PN: My local server was http://127.0.0.1:9090 You may change the settings as per you laravel environment

1. POST - http://127.0.0.1:8000/api/v1/auth/register ( Pre Login )
2. POST - http://127.0.0.1:8000/api/v1/auth/login ( Pre Login )
3. POST - http://127.0.0.1:8000/api/v1/loans/apply ( Post Login )
4. POST - http://127.0.0.1:8000/api/v1/loans/approve ( Post Login )
5. POST - http://127.0.0.1:8000/api/v1/loans/payloan ( Post Login )
6  GET -  http://127.0.0.1:8000/api/v1/loans ( Post Login )
7. GET -  http://127.0.0.1:8000/api/v1/loans/1 ( Post Login )

### **Customer Application Flow**

**Note:** 
1. You will receive JSON responses to every API request
2. We are using JWT Token for authorization and authentication so need to use after login
3. In Postman, We have created environment with value of site_url and token and token is automatically updating after login success
4. Post collection available on root directory of under folder /postman_collection 

**Header Seaction**

Key - Authorization
Value - Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMVwvXC9hcGlcL3YxXC9hdXRoXC9sb2dpbiIsImlhdCI6MTY2MjQwNzAwNCwiZXhwIjoxNjYyNDEwNjA0LCJuYmYiOjE2NjI0MDcwMDQsImp0aSI6InV0U0lzOFZHZEZXMWk4Z0YiLCJzdWIiOjEsInBydiI6IjEzZThkMDI4YjM5MWYzYjdiNjNmMjE5MzNkYmFkNDU4ZmYyMTA3MmUifQ.SkAgSNLKXhB7xnUG_Dgfe34eaJ750s9jV89yc2SjDoI

1. For New Customer, first customer need to register using basic details for that need to visit the api /api/v1/register. ( Pls note your password will be encrypted so kindly memorize it )
    **Required Fields :**
     - First Name
     - Last Name
     - Email
     - Password
    **Response :**
    Response available in Postman Collection

2. You need to now login so visit `/api/v1/auth/login`. Fields required for this request are `email` & `password`
    - We are using JWT Token for authentication and authorization. you need to use a bereer token in every api after login.
     **Required Fields :**
     - email
     - Password
    **Response :**
    Response available in Postman Collection
    
3. You may apply for a loan by visiting `/api/v1/loans/apply` Fields required for this request are `amount` & `tenor`
    **Required Fields :**
     - amount
     - tenor
    **Response :**
    Response available in Postman Collection

4. If you want to approve your loan you may head to `/api/v1/loans/approve` Fields required for this request are `loan_id`

    PN: for loan_id ( You may take a look at `loans` and search for relevant loan ID or you can use api `api/v1/loans`  )

    **Required Fields :**
     - loan_id
    **Response :**
    Response available in Postman Collection

5. Now you need to pay EMIs you may visit `/api/v1/loans/payloan` Fields required for this request are `loan_id` & `amount`

    PN: for loan_id ( You may take a look at `loans` and search for relevant loan ID or you can use api `api/v1/loans`  )

   **Required Fields :**
     - loan_id
    **Response :**
    Response available in Postman Collection

6. For Loan Details, you need to visit `api/v1/loans/{loanId} 
    **Response :**
    Response available in Postman Collection

### Feature and Unit Test Case

Test Cases are available under the root folder of Tests. You can run using below command

**phpunit**

### Demo Credentials
---
*Make sure you have run the command `php artisan db:seed --class UserTableSeeder` before you use these credentials.*

**User:** admin@admin.com\
**Password:** 123456

## Contribution
Feel free to create any pull requests for the project. For proposing any new changes or features you want to add to the project, you can send us an email at following addresses.

    1. Kamlesh Gupta - webworldgk@gmail.com
    




