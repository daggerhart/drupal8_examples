# Custom Drupal 8 Entities w/ Bundle Examples

1. [Most Simple](modules/custom_entities/most_simple) - The Most Simple entity with bundles possible. Easy to create (very little code), hard to use (no links).
1. [Simple](modules/custom_entities/simple) - Simple Entity with bundles that is much more usable than the Most Simple Entity. Has links, useful ListBuilders, and informative messages.
1. [Practical](modules/custom_entities/practical) - More practical entity with bundles, generated bundle permissions, custom access control, entity fields, bundle descriptions, and much better ListBuilders with useful information. Also has interfaces for the Entity classes as best practice.

[Related Blog Post](http://www.daggerhart.com/drupal-8-custom-entities-bundles/)

# Learning about Drupal 8 Events

1. [Module](modules/custom_events)
    1. [Registering services](modules/custom_events/custom_events.services.yml) - Registering services
    1. [Config CRUD Event Subscriber](modules/custom_events/src/EventSubscriber/ConfigEventsSubscriberWithDI.php) - Example event subscriber that listens for Config object events.
    1. [Custom Event - UserLoginEvent](modules/custom_events/src/Event/UserLoginEvent.php) - Custom Event that will be dispatched on `hook_user_login()`.
    1. [Custom Event - Dispatching Events](modules/custom_events/custom_events.module) - Dispatching an event during `hook_user_login()`.
    1. [Custom Event - Subscribing to Custom Event](modules/custom_events/src/EventSubscriber/ConfigEventsSubscriberWithDI.php) - Event Subscriber that listens for our custom UserLoginEvent.

[Related Blog Post](https://www.daggerhart.com/drupal-8-hooks-events-event-subscribers/)

# Services & Dependency Injection

1. [Dependency Injection Examples](modules/dependency_injection_examples)
1. [Services Examples](modules/services_examples)
1. [Calculator](modules/calculator) - More examples of services and dependency injection.

# The most bare-minimum possible Drupal 8 module

1. [Module](modules/blank_module)

# The most bare-minimum possible Drupal 8 theme

1. [Theme](themes/blank_theme) - This can be enabled from the modules folder.

# Cat API custom modules

These modules integrate with various free cat related APIs available online.

1. [Cat Facts](modules/cat_facts)
    1. [Original Blog Post](https://www.hook42.com/blog/consuming-json-apis-drupal-8)
    1. [Related Blog Post](https://www.daggerhart.com/guzzle-requests-json-in-drupal-8/)
1. [Cat API](modules/cat_api)
    * Services
    * Blocks
    * Dependency Injection
