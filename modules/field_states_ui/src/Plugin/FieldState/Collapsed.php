<?php

namespace Drupal\field_states_ui\Plugin\FieldState;

use Drupal\Core\Form\FormStateInterface;
use Drupal\field_states_ui\FieldStateBase;

/**
 * Control details field widget check state in relation to other fields dynamically.
 *
 * @FieldState(
 *   id = "field_state_collapsed",
 *   label = @Translation("Collapsed"),
 *   description = @Translation("Dynamically collapse details field elements dependent on other field states/values.")
 * )
 */
class Collapsed extends FieldStateBase {

  /**
   * {@inheritdoc}
   */
  public function applyState(array &$states, FormStateInterface $form_state, array $context) {
    $states['collapsed'] = [
      ":input[name^='{$this->configuration['target']}']" => [
        $this->configuration['comparison'] => $this->configuration['value'],
      ],
    ];
    return TRUE;
  }

}
