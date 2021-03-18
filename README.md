# RESTful Webservices in Symfony

## Jan Schaedlich | Lead Developer PHP @ Siemens Mobility Portugal

### Workshop am 14.04.2021 auf der SymfonyLive Online German Edition 2021

> Webservices werden mittlerweile in sehr vielen Bereichen der IT zur Integration
> unterschiedlicher Anwendungen verwendet. REST-Webservices spielen
> dabei eine besondere Rolle, da REST sich auf die Grundlagen von HTTP stützt,
> einfach verständlich ist und leicht in bestehende Anwendungen zu integrieren ist.
> In diesem Workshop werden den Teilnehmern sowohl die theoretischen Grundlagen von REST, als auch die praktische Umsetzung mit Symfony näher gebracht.
>
> Mit praxisnahen Beispielen werden Themen wie Serialisierung, Content-Negotiation
> und die Sicherheit von REST-Webservices erklärt und durch realistische
> Übungsaufgaben verdeutlicht.
>
> Neben IDE (oder Texteditor) braucht ihr eine aktuelle Version von PHP und Composer.

Code written for the "RESTful Webservices in Symfony" workshop at SymfonyLive Online German Edition 2021.

This is example code that is not production-ready. It is intended for studying and learning purposes.

(c) 2021 Jan Schaedlich All rights reserved.

## Installation

    # checkout the project
    $ git clone git@github.com:jschaedl/RESTful-Webservices-in-Symfony-2021-04-14.git

    # initialize dev environment
    $ make dev-init
    
    # start webserver
    $ symfony serve -d

## Tools

- Symfony Binary: https://symfony.com/download
- Postman App: https://www.getpostman.com/downloads
  
## Code Challenge

Für eine 2-tägige Konferenz müssen Workshops und Teilnehmer erfasst werden.
Workshops dauern jeweils einen Tag. 
Alle Workshops haben ein Teilnehmerlimit von 25 Personen. 
Jeder Teilnehmer kann jeweils nur an einem Workshop pro Tag teilnehmen. 

Wir werden eine API bauen, mit der man Workshops organisieren kann.
Unsere API soll folgenden grundlegende Features bieten:

- Auflisten aller Workshops
- Lesen eines einzelnen Workshops
- Erstellen eines Workshops
- Aktualisieren eines Workshops
- Löschen eines Workshops
- Auflisten aller Teilnehmer
- Lesen eines einzelnen Teilnehmer
- Erstellen eines Teilnehmers
- Aktualisieren eines Teilnehmers
- Löschen eines Teilnehmers
- Hinzufügen eines Teilnehmers zu einem Workshop
- Entfernen eines Teilnehmers aus einem Workshop
- Das Auflisten von Workshops und Teilnehmern soll eine Paginierung unterstützen 
- Die API soll JSON und XML unterstützen

Zudem wollen wir den Zugriff auf unsere API wie folgt beschränken:

- das Auflisten aller Workshops ist für anonyme Benutzer erlaubt
- das Lesen eines einzelnen Workshops ist nur für eingeloggte Benutzer mit der Rolle ROLE_USER erlaubt
- das Erstellen und Aktualisieren eines Workshops ist nur für eingeloggte Benutzer mit der Rolle ROLE_USER erlaubt
- das Löschen eines Workshops ist nur für eingeloggte Benutzer mit der Rolle ROLE_ADMIN erlaubt
- das Auflisten aller Teilnehmers ist für anonyme Benutzer erlaubt
- das Lesen eines einzelnen Teilnehmer ist nur für eingeloggte Benutzer mit der Rolle ROLE_USER erlaubt
- das Erstellen und Aktualisieren eines Teilnehmer ist nur für eingeloggte Benutzer mit der Rolle ROLE_USER erlaubt
- das Löschen eines Teilnehmer ist nur für eingeloggte Benutzer mit der Rolle ROLE_ADMIN erlaubt
- das Hinzufügen/Entfernen eines Teilnehmers zu/aus einem Workshop ist nur für eingeloggte Benutzer mit der Rolle ROLE_USER erlaubt

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

Wir werden zum testen unsere API eine Postman Collection verwenden.

Siehe: restful-services-in-symfony.postman_collection.json