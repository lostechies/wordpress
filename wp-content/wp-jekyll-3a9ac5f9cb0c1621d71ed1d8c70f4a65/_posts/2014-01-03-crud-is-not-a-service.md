---
id: 110
title: CRUD is Not a Service
date: 2014-01-03T10:05:36+00:00
author: Chris Patterson
layout: post
guid: http://lostechies.com/chrispatterson/?p=110
permalink: /2014/01/03/crud-is-not-a-service/
dsq_thread_id:
  - "2089702478"
categories:
  - Development
---
# Introduction

Many systems implement CRUD (create, read, update, and delete) using a repository pattern. An entity is loaded using a _Get_ method, some business layer logic makes changes to the entity, and ultimately saved using a _Put_ method. This exact pattern is replicated with as many names as there are examples, including _EntityManager_, _EntityDataContext_, _EntityStorage_, etc. In fact, the pattern itself has been completely generalized by libraries such as _NHibernate_, which provides an _ISession_ interface for performing simple CRUD operations (yes, there are many additional advanced features that make NHibernate much more useful than just a simple CRUD library, but that&rsquo;s not the point).

A significant weakness of the repository pattern is ensuring that an entity&rsquo;s state is valid. When an entity is saved, it is important that the contents are valid. If the contents are invalid, such as the order total not equaling the sum of the order items, the resulting inconsistency can spread throughout the application causing additional, and perhaps greater inconsistencies.

Most of the time, developers using the repository pattern define classes for entities with properties for the attributes of the entity. And in most cases, the properties allow both reads and writes &ndash; making it possible for entity to become invalid. The repository pattern also does not allow intent to be either expressed or captured as changes are made.

In order to properly validate an entity, the validation logic may need access to additional resources. For example, adding an activity to an itinerary may need to verify that there are seats available for a dining activity. Beyond simple validation, adding the activity to an itinerary may need to allocate an available seat to the itinerary&rsquo;s owner. Subsequently, removing the activity would require that the previously allocated seat be released so that is available to others.

As systems evolve, this type of behavior gets added to the repository class, checking for property changes in the _Put_ method and invoking services when changes are found. The more property changes that require external systems to be notified, the more complex the _Put_ method becomes resulting in a greater number of dependencies in the repository class.

> _Don&rsquo;t even ask what happens when the entity is saved and the property changes, having invoked external services are not persisted due to a transaction timeout or deadlock in the storage system. And don&rsquo;t simply suggest that invoking the services after the save is complete is the right answer, because then what happens when the services cannot be invoked due to a network or availability issue._

# Command Query Separation

Command Query Separation (or CQS) is a pattern that separates commands (typically write operations) from queries (including reads and operations that do not change data). By separating the concerns of reading and writing, it is possible to tune a system to meet specific scaling requirements without generalizing for both operations.

The following provides an example of how CQS can be used to implement CRUD operations. With each operation, an approach is presented that allows for separation of concerns as well as an implementation that can scale reads and writes separately.

## Create

Consider, for example, a dining reservation system for a local restaurant. The _Reservation_ service exposes an API to schedule a reservation where the client specifies the date, number of guests, and the desired seating time. When called, the service checks availability and either adds the reservation to the calendar, or fails and notifies the caller that the requested time is not available. If the reservation is added, a table is reserved for the guests and the table is removed from the available seating. Once all available seating is reserved, the service will no longer accept reservations.

The scheduling API above is an example of a _command_. A command tells a service to perform an operation. The service is responsible for implementing the command&rsquo;s behavior, and is also the ultimate authority as to whether the command can be completed.

From the perspective of the command&rsquo;s initiator, the contract is well defined. Submit the required arguments (date, time, and the number of guests), and observe one of the two possible outcomes (scheduled, or unavailable). As long as there are available seats at the requested time, the reservation should succeed. If the command fails due to lack of availability, the initiator can choose to adjust the arguments (such as requesting a later time, or selecting a different date) and resubmit the command, or it can decide instead to try another time to check if an opening becomes available.

## Read

In order to give the initiator a chance of successfully scheduling a reservation, it&rsquo;s important that the reservation systems constraints are available so that initiators are able to submit reservations that will be accepted. This can be done many ways, but one way would be to expose the availability through a separate service.

For example, an application may display the restaurant&rsquo;s availability to the user so that the user can select a time. At the minimum, having access to the restaurant&rsquo;s days and hours of operation would allow the user to know when the restaurant is open. However, the restaurant may only take reservations in the evening and on weekends. To convey this information to the application and the user, the availability service may supply more detailed availability including ranges of time and the seating availability for each range.

The additional information provided by the availability service enables the application to determine in advance if a reservation will be accepted. If there is no seating available at a particular date and time, the application can assume that submitting a reservation for the date and time will fail. The application is not prevented from submitting the reservation, but it is likely that the reservation will fail.

## Update

Plans change, and likewise the reservation service need to be able to make changes to reservations. Depending upon the type of change, however, the service needs to follow different behaviors.

For example, if the reservation time changes, the service would need to determine if there was sufficient capacity at the new time for the reservation. On the other hand, if the number of guests increased, the service would need to ensure there was either sufficient seating at the already assigned table or if a larger table was available at the same time. A simple change, such as updating the name on the reservation, might not require any checks at all &ndash; unless the new name is identified as a VIP, in which case a check for upgraded tables or perhaps special menu selections would be performed to ensure that the VIP is treated to the best possible service.

As the above examples clearly show, an update is not just a save operation. An update is a general term given to a wide variety of changes that may be applied to a reservation. Since the behavior of each change is different, each change should also be handled differently. A _command_ should be created to define the contract for each change, and each command should be explicitly named to describe the change (_UpdateReservationName_, _ChangeReservationGuests_, _ChangeReservationTime_).

While the update has changed from a single &ldquo;write my object&rdquo; operation to three separate commands, it is now easier to reason about the behavior of each command. If a new reservation time is requested, the initiator could check the published availability information and predetermine if the time slot is available. The initiator is not prevented from sending the command based on this information, but the likelihood of success is greater.

### Aggregate Roots and Scoping

An aggregate root is a form of transactional boundary (defined in _Domain Driven Design_ by _Eric Evans_) which defines the scope of an operation and its related data). For example, if the reservation service managed a list of guests with each reservation, the reservation would be the aggregate root and the list of guests would be contained within the reservation. This means that the addition or removal of a guest would be performed by or with the aggregate root. In practice, such as with a relational database, adding a guest to the reservation would not involve simply inserting into a _ReservationGuest_ table, but actually loading the reservation and adding a guest. The reservation is the root entity, and the guests are a related or child entity.

The reason for this is that a reservation should be treated as a whole and not a set of related entities. If the system has a rule that a reservation cannot exceed eight guests, and guests are arbitrarily added outside of the reservation, the logic to validate the number of guests ends up in multiple places (just read this as cut-n-paste, which makes it quite obvious why it is a bad thing). Keeping the validation logic as part of the reservation makes the rules easier to discover and understand compared to having validation logic spread across the service.

## Delete

Continuing with the example, it&rsquo;s likely that a guest may cancel a reservation. Plans change, and the service should be able to remove a reservation that is no longer required.

To support canceling a reservation, the service may provide an additional API to cancel a reservation using the reservation number. When the command is received, the service would look up the reservation. If the reservation exists, the reservation would be marked as canceled and removed from the schedule &ndash; making the table available for scheduling by other patrons. If the reservation does not exist, the command would fail but the failure does not have any other effects. If the reservation existed but was already canceled, the command could be acknowledged as already canceled (there is no need to cancel a canceled reservation, but not failing ensures that the command is processed idempotently).

The fact that the reservation existed does not change, so it is important that the history of the reservation is retained. While the service could simply delete the reservation from storage, the stakeholders may want to keep a history of reservations for future use, such as marketing or promotional events, or to follow up to solicit feedback as to why the reservation was canceled.

## Auditing

When a command is executed, such as adding an activity to an itinerary, it is important to retain an audit trail of changes. This audit trail is important in case the contents of the itinerary are disputed. For example, a customer may argue that they did not add a particular activity or that an activity is missing. Without an audit trail, it would be impossible to determine the contents of an itinerary at a previous point in time or who made any changes to the itinerary.

Retaining a history of commands executed on the itinerary along with preventing itinerary changes outside of the available commands can provide a reliable audit trail should the need arise. Additionally, ensuring that each command includes the user who initiated the command along with timestamps indicating when the command was initiated and executed can provide a chronological view of the changes made to the entity.

To summarize a statement commonly made by Greg Young, &ldquo;So you have an audit trail, how do you know it&rsquo;s right?&rdquo;

By retaining every successful command, it is possible to rebuild the state of a reservation. In fact, in an event-sourced model, the actual commands are used to determine the current state. There are use cases for each approach, so if you have a highly event-based model, event sourcing may be worth consideration.

# Bonus: Transferring Data Between Systems

In many organizations, separate test and production systems are used so that integrators and developers can test software or configuration changes prior to deploying them on production. For example, an integrator may configure a new customer on the test system prior to moving that configuration into production. More often than not, this transfer is performed using simple CRUD operations &ndash; typically behind the facade of an &ldquo;import/export&rdquo; link.

**A disadvantage of using bulk CRUD operations when transferring configuration between systems is that the system itself is not a participant in the data import process.**

## Using Commands to Transfer Data

Rather than transfer data at the entity level, the data in the source system should be used to generate a sequence of commands that can be executed on the target system. Those commands could include references to the original commands executed on the source system, along with the time those commands were originally executed and the initiating user details. Retaining this information may be crucial as changes are deployed, ensuring that the user performing the transfer is not made responsible for the actual changes performed by another user.

# Conclusion

The use of commands to perform the creation, updating, and deleting of data has clear advantages over simple data access layer operations. Change tracking, auditing, and validation are critical to ensure that data is valid. As with most technical choices, whether or not this level of validation is required depends upon your requirements. in my experience, more often than not, the level of detail is required as auditing and change tracking eventually makes its way into the backlog.