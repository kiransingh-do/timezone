<?php

/**
 * @file
 * Contains \Drupal\timezone\EventSubscriber\TimezoneSubscriber.
 */

  namespace Drupal\timezone;

  use Symfony\Component\EventDispatcher\EventSubscriberInterface;
  use Symfony\Component\HttpKernel\KernelEvents;
  use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
  use Drupal\Core\Datetime\DrupalDateTime;

  /**
   * Add custom headers.
   */
  class TimezoneSubscriber implements EventSubscriberInterface {

    public function __construct() {
     $this->config = \Drupal::config('time_zone.settings')->getRawData();
    }

    /**
     * Set current user language in header.
     */
    public function onRespond() {
      $loc = $this->config['timezone'];
      $date = new DrupalDateTime();
      $date->setTimezone(new \DateTimeZone($loc));
      $date_time = $date->format('jS M, Y - H:i A');

      return $date_time;
    }

    /**
     * Get subscribed events.
     */
    public static function getSubscribedEvents() {
      $events[KernelEvents::RESPONSE][] = ['onRespond'];

      return $events;
    }

  }
