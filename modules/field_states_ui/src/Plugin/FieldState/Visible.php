<?php

namespace Drupal\field_states_ui\Plugin\FieldState;

use Drupal\Core\Form\FormStateInterface;
use Drupal\field_states_ui\FieldStateBase;

/**
 * Control field widget visibility in relation to other fields dynamically.
 *
 * @FieldState(
 *   id = "field_state_visible",
 *   label = @Translation("Visible"),
 *   description = @Translation("Dynamically control field widget visibility dependent on other field states/values. This will show the field only if the condition(s) are met (if not met the field will be hidden).")
 * )
 */
class Visible extends FieldStateBase {

  /**
   * {@inheritdoc}
   */
  public function applyState(array &$states, FormStateInterface $form_state, array $context) {
    $states['visible'] = [
      ":input[name^='{$this->configuration['target']}']" => [
        $this->configuration['comparison'] => $this->configuration['value'],
      ],
    ];
    return TRUE;
  }

}
