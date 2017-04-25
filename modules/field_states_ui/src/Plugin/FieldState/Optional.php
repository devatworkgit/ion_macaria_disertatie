<?php

namespace Drupal\field_states_ui\Plugin\FieldState;

use Drupal\Core\Form\FormStateInterface;
use Drupal\field_states_ui\FieldStateBase;

/**
 * Control field widget interactability in relation to other fields dynamically.
 *
 * @FieldState(
 *   id = "field_state_optional",
 *   label = @Translation("Optional"),
 *   description = @Translation("Dynamically make field optional dependent on other field states/values.")
 * )
 */
class Optional extends FieldStateBase {

  /**
   * {@inheritdoc}
   */
  public function applyState(array &$states, FormStateInterface $form_state, array $context) {
    $states['optional'] = [
      ":input[name^='{$this->configuration['target']}']" => [
        $this->configuration['comparison'] => $this->configuration['value'],
      ],
    ];
    return TRUE;
  }

}
