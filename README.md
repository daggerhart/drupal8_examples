# Custom Drupal 8 Entities w/ Bundle Examples

1. [Most Simple](modules/most_simple) - The Most Simple entity with bundles possible. Easy to create (very little code), hard to use (no links).
1. [Simple](modules/simple) - Simple Entity with bundles that is much more usable than the Most Simple Entity. Has links, useful ListBuilders, and informative messages. 
1. [Practical](modules/practical) - More practical entity with bundles, generated bundle permissions, custom access control, entity fields, bundle descriptions, and much better ListBuilders with useful information. Also has interfaces for the Entity classes as best practice.


[Related Blog Post](http://www.daggerhart.com/drupal-8-custom-entities-bundles/)

# Learning about Drupal 8 Events

1. [Module](modules/custom_events) - 
1. [Registering services](modules/custom_events/custom_events.services.yml) - Registering services 
1. [Config CRUD Event Sbuscriber](modules/custom_events/src/EventSubscriber/ConfigEventsSubscriber.php) - Example event subscriber that listens for Config object events. 
1. [Custom Event - UserLoginEvent](modules/custom_events/src/Event/UserLoginEvent.php) - Custom Event that will be dispatched on `hook_user_login()`. 
1. [Custom Event - Dispatching Events](modules/custom_events/custom_events.module) - Dispatching an event during `hook_user_login()`.
1. [Custom Event - Subscribing to Custom Event](modules/custom_events/src/EventSubscriber/ConfigEventsSubscriber.php) - Event Subscriber that listens for our custom UserLoginEvent. 

[Related Blog Post](https://www.daggerhart.com/drupal-8-hooks-events-event-subscribers/)

# The most bare-minimum possible Drupal 8 module

1. [Module](modules/blank_module)
