# RESTful Webservices in Symfony

## Coding Challenge 10 - JSON WEB TOKEN

### Tasks

Let's set up the Authentication/Authorization for our API based on Json Web Token

1. Implement a Token provider

- configure the security system for basic auth
- add a TokenController to retrieve a token

2. Implement a Guard

- implement a JwtGuardAuthenticator

3. Secure your Controllers tp meet the requirements described in README.md

- use the `#[IsGranted]` attribute

### Solution

#### Preparation

- require Symfony's SecurityBundle: `composer req security`
- require LexikJWTAuthenticationBundle: `composer req lexik/jwt-authentication-bundle`
- run `php bin/console lexik:jwt:generate-keypair`

#### GuardAuthenticator

- adjust firewall configuration (firewall for token: basic auth; firewall for api: guard authenticator)
- implement a `JwtTokenAuthenticator` extending the `AbstractGuardAuthenticator`
- configure the `JwtTokenAuthenticator` on the api firewall (`guard` option)
- add `#[IsGranted]` attributes to your controller actions
- add an Authorization header to your Postman endpoints

#### Make things shiny

- use the Serializer to create a nice error response in the `JwtTokenAuthenticator::start()` method
- implement the `JwtTokenAuthenticator::onAuthenticationFailure()` and use the Serialize to return a
  HTTP 401 Unauthorized Response with a nice error message
