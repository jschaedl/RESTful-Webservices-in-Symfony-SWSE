# RESTful Webservices in Symfony

## Coding Challenge 6 - POST vs. PUT

### Tasks

- implement Controllers for creating and updating Attendees and Workshops
- both should be possible with json and xml

### Solution

- use an `ArgumentValueResolver` to deserialize the request's content
- use the EntityManager to save the object into the database
- for CREATE: use method `POST`, return HTTP 201 (Created) Status Code and set the Location header with the help of the `UrlGeneratorInterface`
- for UPDATE: use method `PUT`, return HTTP 204 (No Content) Status Code and leave the response body empty
