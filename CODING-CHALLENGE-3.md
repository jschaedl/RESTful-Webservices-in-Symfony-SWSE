# RESTful Webservices in Symfony

## Coding Challenge 3 - Pagination

### Tasks

- add pagination to your Workshop and Attendee list actions using a `page` and `size` query parameter

### Solution

- introduce query params `page` and `size` in your ListControllers
- use the Doctrine Paginator to paginate the Workshop and Attendee lists
- implement a `PaginatedCollection` object and add the properties `items`, `total` and `count`
- implement a `PaginationFactory` to encapsulate your pagination logic
