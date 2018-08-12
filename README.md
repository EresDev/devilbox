**MyHammer REST API**
----
  The API provides CRUD operations on entity Job and read-only access to the list of entity Service.
  
  The main application is present is following directory:
  
  ```devilbox/data/www/myhammer```
  
  To run the application, make sure you have docker installed  and running on your system. Download the entire directory and run following commands to start the server:
  
  host> ```cd devilbox```
  
  host> ```docker-compose up -d httpd mysql php```
  
  After running the server, the API will be accessible at URL ```http://myhammer.loc/``` For example, to access the list of Services, send a GET request to ```http://myhammer.loc/services``` More information can be found bellow in API documentation.
  
  To enter into the php container, depending upon your operating system
  
  host> ```cd devilbox```
  
  windows-host> ```shell.bat```
  
  or
  
  linux-host> ```shell.sh```
  
  Use tool like postman to test the API. https://www.getpostman.com/
  
  In case you need to update MySQL database details, you have to make two databases and configure them in two places. One of phpunit and other for live. 
  
  For live makes changes in ```devilbox/data/www/myhammer/app/.env``` file.
  
  For phpunit makes changes in ```devilbox/data/www/myhammer/app/phpunit.xml.dist``` file.
  
  I see that git ignored several folder from devilbox while pushing to github. I believe those are related to environment. But if you need complete folder, I have uploaded it on wetransfer. Here https://we.tl/MkLdKs5koO

**Get list of Services**
----
  Returns json data about the complete list of available Services.

* **URL**

  /services

* **Method:**

  `GET`
  
*  **URL Params**

    None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
    ```json
     [
         {
             "id": 1,
             "official_id": "804040",
             "name": "Sonstige Umzugsleistungen"
         },
         {
             "id": 2,
             "official_id": "802030",
             "name": "Abtransport, Entsorgung und Entrümpelung"
         },
         {
             "id": 3,
             "official_id": "411070",
             "name": "Fensterreinigung"
         },
         {
             "id": 4,
             "official_id": "402020",
             "name": "Holzdielen schleifen"
         },
         {
             "id": 5,
             "official_id": "108140",
             "name": "Kellersanierung"
         }
     ]
    ```              
 
* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/services",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
  
**Get Single Job**
----
  Returns json data about requested Job with related Service.

* **URL**

  /job/:id

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:**
 
   `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
    ```json
     {
         "id": 2,
         "title": "Sample Job Title 2",
         "zip": "10115",
         "city": "Berlin",
         "description": "Lorem Ipsum 2 is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
         "action_datetime": "2019-02-01T10:30:00+01:00",
         "post_datetime": "2018-08-15T10:30:00+02:00",
         "service": {
             "id": 2,
             "official_id": "802030",
             "name": "Abtransport, Entsorgung und Entrümpelung"
         }
     }
    ```              
* **Failure Response:**

  * **Code:** 404 Not Found<br /> 
      **Content:** 
      ```json
       "The job you requested was not found."
      ```    
  
* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/job/2",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
  
**Save Single Job**
----
  Save a new Job. 

* **URL**

  /job

* **Method:**

  `POST`
  
*  **URL Params**

   **Required:**
 
   None

* **Data Params**
    
   **Required:**
   
  `title=[string]`  5-50 characters
  
  `zip=[zipCode]` German Zip Code Only
  
  `city=[string]` max 45 characters
  
  `action_datetime=[datetime]` Datetime in future, format 2019-11-11 10:10:02
  
  `service_id=[integer]` 
  
  **Optional:**
  
    `description=[string]` max 3000 characters

* **Success Response:**

  * **Code:** 200 <br />
  
    **Content:** 
    ```json
     {
         "id": 2,
         "title": "Sample Job Title 2",
         "zip": "10115",
         "city": "Berlin",
         "description": "Lorem Ipsum 2 is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
         "action_datetime": "2019-02-01T10:30:00+01:00",
         "post_datetime": "2018-08-15T10:30:00+02:00",
         "service": {
             "id": 2,
             "official_id": "802030",
             "name": "Abtransport, Entsorgung und Entrümpelung"
         }
     }
    ```              

* **Failure Response:**

  * **Code:** 406 Not Acceptable<br /> 
  **Content:** 
   ```json
         [
             {
                 "property_path": "title",
                 "message": "Title cannot be empty."
             },
             {
                 "property_path": "zip",
                 "message": "ZipCode is not valid."
             },
             {
                 "property_path": "city",
                 "message": "City cannot be empty."
             },
             {
                 "property_path": "service",
                 "message": "Service is not correct."
             }
         ]
    ``` 
  
* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/job",
      dataType: "json",
      type : "POST",
      data : {
              "title": "A sample title",
              "description": "Sample Descriptions",
              "service_id": "1",
              "zip": "10115",
              "city": "Berlin",
              "action_datetime": "2019-11-11 11:11:11"
            },
      success : function(r) {
    	console.log(r);
      }
    });
  ```
    
**Update Single Job**
----
  Returns json data about requested Job with related Service.

* **URL**

  /job/:id

* **Method:**

  `PUT`
  
*  **URL Params**

   **Required:**
 
   ```id[integer]```

* **Data Params**
    
   **Required:**
   
  `title=[string]`  5-50 characters
  
  `zip=[zipCode]` German Zip Code Only
  
  `city=[string]` max 45 characters
  
  `action_datetime=[datetime]` Datetime in future, format 2019-11-11 10:10:02
  
  `service_id=[integer]` 
  
  **Optional:**
  
    `description=[string]` max 3000 characters

* **Success Response:**

  * **Code:** 200 <br />
  
    **Content:** 
    ```json
     {
         "message": "Job updated successfully.",
         "job_id": 1
     }
    ```              

* **Failure Response:**

  * **Code:** 406 Not Acceptable<br /> 
  **Content:** 
      ```json
       [
           {
               "property_path": "title",
               "message": "Title cannot be empty."
           },
           {
               "property_path": "zip",
               "message": "ZipCode is not valid."
           },
           {
               "property_path": "city",
               "message": "City cannot be empty."
           },
           {
               "property_path": "service",
               "message": "Service is not correct."
           }
       ]
      ```  
  
* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/job/1",
      dataType: "json",
      type : "PUT",
      data : {
              "title": "A sample title",
              "description": "Sample Descriptions",
              "service_id": "1",
              "zip": "10115",
              "city": "Berlin",
              "action_datetime": "2019-11-11 11:11:11"
            },
      success : function(r) {
    	console.log(r);
      }
    });
  ```
  
**Delete Single Job**
----
  To delete a Job. 

* **URL**

  /job/:id

* **Method:**

  `DELETE`
  
*  **URL Params**

   **Required:**
 
   ```id[integer]```

* **Success Response:**

  * **Code:** 200 <br />
  
    **Content:** 
    ```json
     "Job deleted successfully."
    ```              

* **Failure Response:**

  * **Code:** 404 Not Found<br /> 
  **Content:** 
      ```json
       "Job was not found."
      ```  
  
* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/job/1",
      dataType: "json",
      type : "DELETE",
      success : function(r) {
    	console.log(r);
      }
    });
  ```
