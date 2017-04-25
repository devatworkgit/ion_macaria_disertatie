<?php

namespace Drupal\field_states_ui\Plugin\FieldState;

use Drupal\Core\Form\FormStateInterface;
use Drupal\field_states_ui\FieldStateBase;

/**
 * Control checkbox field widget check state in relation to other fields dynamically.
 *
 * @FieldState(
 *   id = "field_state_checked",
 *   label = @Translation("Checked"),
 *   description = @Translation("Dynamically check checkbox dependent on other field states/values.")
 * )
 */
class Checked extends FieldStateBase {

  /**
   * {@inheritdoc}
   */
  public function applyState(array &$states, FormStateInterface $form_state, array $context) {
    $states['checked'] = [
      ":input[name^='{$this->configuration['target']}']" => [
        $this->configuration['comparison'] => $this->configuration['value'],
      ],
    ];
    return TRUE;
  }

}
