<?php

namespace Drupal\field_states_ui\Plugin\FieldState;

use Drupal\Core\Form\FormStateInterface;
use Drupal\field_states_ui\FieldStateBase;

/**
 * Control field widget visibility in relation to other fields dynamically.
 *
 * @FieldState(
 *   id = "field_state_invisible",
 *   label = @Translation("Invisible (Hide)"),
 *   description = @Translation("Dynamically control field widget visibility dependent on other field states/values. This will hide the field if the condition(s) are met.")
 * )
 */
class Invisible extends FieldStateBase {

  /**
   * {@inheritdoc}
   */
  public function applyState(array &$states, FormStateInterface $form_state, array $context) {
    $states['invisible'] = [
      ":input[name^='{$this->configuration['target']}']" => [
        $this->configuration['comparison'] => $this->configuration['value'],
      ],
    ];
    return TRUE;
  }

}
