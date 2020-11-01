# ci-template
CI infrastructure with both an API server and frontend UI interface.

## Table of Contents

* [Setup](#Setup)
* [API](#api)
  * [Auth](#auth)
    * [Create User](#create-user)
    * [Login](#login)
    * [Verify Token](#verify-token)
  * [OTP](#otp)
    * [Create OTP](#create-otp)
    * [Verify OTP](#verify-otp)
* [HTML Pages](#html-pages)

## Setup
1. Change the `$allowed_domains` property in config.php
2. Change base URL folder property (the part of the URL after domain) in config.php
3. Add localhost and production database configuration in database.php
4. Make sure the .htaccess file is in the root directory

## API
* This section of the API looks into how the API is structured. The api route is defined as 
> `http://{domain}/{CI directory}/api/{route}`

* An API route can be easily created by adding a controller named 
  > `{name}Api.php`. 
  > _Ex: SupplierApi.php_
  * The route to access would be 
  > `http://{domain}/{CI directory}/api/{name}/{function}` 
  > _Ex: {base_url}/api/supplier/get/1_
  * The route is flexible (can have as many function parameters as needed)

  ### Auth
  * Auth works using `tbltoken`, `user` and `verify` tables.
    * `tbltoken` is used to create and hold tokens for already-authenticated login
    * `user` holds user entity information including the password hash
    * `verify` is used to verify an account using account creation. This version of the template uses SMS OTP verification

    #### Create User
    > `api/auth/create_user/`
    * Input: `password`, `email` and `fullName`
    * Output: User object and token

    #### Login
    > `api/auth/login/`
    * Input: `password` and `email`
    * Output: User object and token

    #### Verify Token
    > `api/auth/verify_token`
    * Input: `token`
    * Output: User object

  ### OTP
  * OTP works using the `verify` table

    #### Create OTP
    > `api/otp/create`
    * Input: `username`
    * Output: string 'success'
    * Error: `{"error": "otp_failed"}`

    #### Verify OTP
    > `api/otp/verify`
    * Input: `username` and `otp`
    * Output: `{"message": "otp_success"}`

## HTML Pages
* The controller for HTML pages is the `Pages` controller
* The default routing configuration states that the default route is the `index()` in the `Pages` controller
  * If the user has logged in, the 'main page' is shown; otherwise, the login screen is shown
* All page routes must be declared explicitly after the controller is created
  * Sample page routes are provided in the router file