<?php

namespace Drupal\store_less_css\EventSubscriber;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class store_less_cssSubscriber implements EventSubscriberInterface {

  public function checkForRedirection(GetResponseEvent $event) {
    $config = \Drupal::config('less.settings');
    if ($config->get(LESS_DEVEL) ?: FALSE) {
      // Flush asset file caches.
      \Drupal::state()->set('system.css_js_query_string', base_convert(REQUEST_TIME, 10, 36));
      drupal_set_message(t('CSS and JavaScript cache cleared.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = array('checkForRedirection');
    return $events;
  }

}