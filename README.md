# User Management System

## Initialize
* Run `composer install`
* Then setup your environment via `.env` file
* Run `php artisan migrate` to create database tables
* Run `php artisan db:seed` so you have two types of users in database : 
    #####Admin
        email: admin@local
        password: abc
    #####User
        email: regular1@local
        password: abc
        
* Run `php artisan jwt:secret` to have a fresh secret key (not necessary)
* You can also run test units by typing `composer test`
> There is a directory named `documents` in project files which includes all the demanded files for this test such as (database diagram, domain model diagram, Postman collection json file).

<hr>

## API Entry Points

* [API Response Convention](#api-response-convention)
* [Get Token](#user-login)
* [Admin - Create User](#admin-create-user)
* [Admin - Delete User](#admin-delete-user)
* [Admin - Get Users](#admin-get-users)
* [Admin - Create Group](#admin-create-group)
* [Admin - Delete Group](#admin-delete-group)
* [Admin - Get Groups](#admin-get-groups)
* [Admin - Attach User to Group](#admin-attach-group)
* [Admin - Detach User from Group](#admin-detach-group)

### API Response Convention

Here is a sample of API response object : 

```json
{
    "code": 0,
    "message": "User created successfully!",
    "data": {
        "name": "John Doe",
        "email": "j.doe@local",
        "id": 126
    }
}
```

All the response objects consist of these three fields : 

* code
* message 
* data

#####code
A response code designates that a request was successful or not and it is following the convention below.

| Code | Status    |
| ---- | --------- |
|   0  | Success   |
|   -1  | General Error   |
|   -2  | Invalid Input   |
|   -3  | Invalid Credentials |
|   -4  | User Already A Member |
|   -5  | Group Is Not Empty  |

#####message
Verbose information about the request status.

for example : `Group created successfully!`

#####data
Consists all the necessary data of the relevant task.

for example : 

```json
{
    "name": "John Doe",
    "email": "j.doe@local",
    "id": 126
}
```

<hr>

### User Login

Route : `/api/v1/users/login`

Method : `POST`

Body : 

```json
{
    "email": "admin@local",
    "password": "abc"
}
```

<hr>

### Admin Create User

Route : `/api/v1/admins/users`

Method : `POST`

Body :

```json
{
    "name": "John Doe",
    "email": "j.doe@local",
    "password": "abc"
}
```

<hr>

### Admin Delete User

Route : `/api/v1/admins/users/{user-id}`

Method : `DELETE`

<hr>

### Admin Get Users

Route : `/api/v1/admins/users`

Method : `GET`

<hr>

### Admin Create Group

Route : `/api/v1/admins/groups`

Method : `POST`

Body : 

```json
{
    "name": "work",
    "description": "Working employees"
}
```

<hr>

### Admin Delete Group

Route : `/api/v1/admins/groups/{group-id}`

Method : `DELETE`

<hr>

### Admin Get Groups

Route : `/api/v1/admins/groups`

Method : `GET`

<hr>

### Admin Attach Group

Route : `/api/v1/admins/groups/{group-id}/user/{user-id}`

Method : `GET`

<hr>

### Admin Detach Group

Route : `/api/v1/admins/groups/{group-id}/user/{user-id}`

Method : `DELETE`

