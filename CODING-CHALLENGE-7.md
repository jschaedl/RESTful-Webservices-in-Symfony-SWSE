# RESTful Webservices in Symfony

## Coding Challenge 7 - Validation

### Tasks

- introduce the Symfony Validator to validate the request content used to create and update Workshops and Attendees

### Solution

- require the Symfony Validator: `composer require validator`
- add validation constraints to your Entity properties (NotBlank, Email)
- use the Validator Service in your `ValueResolver`s
- for now throw an `BadRequestHttpException` on validation errors