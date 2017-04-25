<?php

namespace Drupal\field_states_ui\Plugin\FieldState;

use Drupal\Core\Form\FormStateInterface;
use Drupal\field_states_ui\FieldStateBase;

/**
 * Control field widget interactability in relation to other fields dynamically.
 *
 * @FieldState(
 *   id = "field_state_enabled",
 *   label = @Translation("Enable"),
 *   description = @Translation("Dynamically control field widget interaction dependent on other field states/values. This will enable the field if the condition(s) are met.")
 * )
 */
class Enabled extends FieldStateBase {

  /**
   * {@inheritdoc}
   */
  public function applyState(array &$states, FormStateInterface $form_state, array $context) {
    $states['enabled'] = [
      ":input[name^='{$this->configuration['target']}']" => [
        $this->configuration['comparison'] => $this->configuration['value'],
      ],
    ];
    return TRUE;
  }

}
