# RESTful Webservices in Symfony

## Jan Schaedlich | Lead Developer PHP @ Siemens Mobility Portugal

### Workshop at SymfonyWorld Online Summer Edition 2021 on 15. June 2021

> Nowadays RESTful Apis are powering the web and are used in almost every web application.
> In this workshop you will learn the fundamental principles of REST and how you can implement a RESTful Application using Symfony. 
>
> We will start with the basics of REST and will cover some more advanced topics like Serialization, Content-Negotiation, Security afterwards.
> Besides all the theory you can deepen your learnings on every topic while doing the provided coding challenges.
>
> Web services are now used in many areas of IT to integrate different applications. REST web services play a special role here, as REST is based on the fundamentals of HTTP, is easy to understand and easy to integrate into existing applications. In this workshop, the participants are introduced to both the theoretical basics of REST and the practical implementation with Symfony.
> 
> With practical examples, topics such as serialization, content negotiation and the security of REST web services are explained and illustrated by realistic exercises.
>
> In addition to an IDE (or text editor) you need a current version of PHP, Composer and Symfony CLI.

Code written for the "RESTful Webservices in Symfony" workshop at SymfonyWorld Online Summer Edition 2021.

This is example code that is not production-ready. It is intended for studying and learning purposes.

(c) 2021 Jan Schaedlich All rights reserved.

## Installation

    # checkout the project
    $ git clone git@github.com:jschaedl/RESTful-Webservices-in-Symfony.git

    # initialize dev environment
    $ make dev-init
    
    # start webserver
    $ symfony serve -d

## Tools

- Symfony Binary: https://symfony.com/download
- Postman App: https://www.getpostman.com/downloads
  
## Coding Challenge

For a 2-day conference, workshops and participants must be recorded.
Each workshop last one day.
All workshops have a participant limit of 25 people.
Each participant can only take part in one workshop per day.

We are going to build an API that can be used to organize workshops.
Our API should offer the following basic features:

- List all workshops
- Read a single workshop
- Create a workshop
- Update a workshop
- Delete a workshop
- List all participants
- Read a single participant
- Create a participant
- Update a participant
- Delete a participant
- Add a participant to a workshop
- Remove a participant from a workshop
- The listing of workshops and participants should support pagination
- The API should support JSON and XML

We also want to limit access to our API as follows:

- Listing of all workshops is allowed for anonymous users
- Reading a single workshop is only allowed for logged-in users with the ROLE_USER role
- Creating and updating a workshop is only allowed for logged-in users with the ROLE_USER role
- Deleting a workshop is only allowed for logged in users with the ROLE_ADMIN role
- Listing of all participants is allowed for anonymous users
- Reading a single participant is only allowed for logged-in users with the ROLE_USER role
- Creating and updating a participant is only allowed for logged-in users with the ROLE_USER role
- Deleting a participant is only allowed for logged-in users with the ROLE_ADMIN role
- Adding/removing a participant to/from a workshop is only allowed for logged-in users with the ROLE_USER role

## Endpoints

### Workshop

HTTP Method | Endpoint
----------- | --------
 GET        | /workshops
 POST       | /workshops
 GET        | /workshops/{workshopId}
 PUT        | /workshops/{workshopId}
 DELETE     | /workshops/{workshopId}
 POST       | /workshops/{workshopId}/attendees/{attendeeId}/add
 POST       | /workshops/{workshopId}/attendees/{attendeeId}/remove

### Attendee

HTTP Method | Endpoint
----------- | --------
 GET        | /attendees
 POST       | /attendees
 GET        | /attendees/{attendeeId}
 PUT        | /attendees/{attendeeId}
 DELETE     | /attendees/{attendeeId}

## Testing

We will use a Postman Collection to test our API: restful-services-in-symfony.postman_collection.json