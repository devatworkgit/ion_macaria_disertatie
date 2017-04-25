<?php

namespace Drupal\field_states_ui\Plugin\FieldState;

use Drupal\Core\Form\FormStateInterface;
use Drupal\field_states_ui\FieldStateBase;

/**
 * Control checkbox field widget check state in relation to other fields dynamically.
 *
 * @FieldState(
 *   id = "field_state_unchecked",
 *   label = @Translation("Unchecked"),
 *   description = @Translation("Dynamically uncheck checkbox dependent on other field states/values.")
 * )
 */
class Unchecked extends FieldStateBase {

  /**
   * {@inheritdoc}
   */
  public function applyState(array &$states, FormStateInterface $form_state, array $context) {
    $states['unchecked'] = [
      ":input[name^='{$this->configuration['target']}']" => [
        $this->configuration['comparison'] => $this->configuration['value'],
      ],
    ];
    return TRUE;
  }

}
