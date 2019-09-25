<?php 
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Theme\ThemeSettings;
use Drupal\system\Form\ThemeSettingsForm;
use Drupal\Core\Form;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Component\Utility\Html;

function THEME_form_system_theme_settings_alter(&$form, FormStateInterface $form_state) {
 /* $css_file_name = 'custom';
  $clean_alias = Html::cleanCssIdentifier($css_file_name);
  drupal_set_message(drupal_get_path('theme', 'sagar'));*/
  $form['sagar'] = array(
    '#type' => 'vertical_tabs',
    '#title' => t('Theme Settings'),
    '#weight'       => -999,
  );

  get_typography_settings($form, $form_state);
  get_layout_settings($form);
  get_sidebar_settings($form);
  // get_custom_css_settings($form);
  $form['#validate'][] = 'sagar_form_system_theme_settings_validate';
  $form['actions']['submit']['#submit'][] = 'sagar_form_system_theme_settings_submit';
  // $form_state->setCached(FALSE);

  return $form;
}


function get_typography_settings(array &$form, &$form_state){
    $name_field = $form_state->get('num_names');
    $form['typography'] = array(
      '#type'  => 'details',
      '#title' => t('Typography'),
      '#group' => 'sagar'
    );
    $form['typography']['#tree'] = TRUE;
    $form['typography']['names_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => t('Peoples'),
      '#prefix' => "<div id='names-fieldset-wrapper'>",
      '#suffix' => '</div>',
    ];
    if (empty($name_field)) {
      $name_field = $form_state->set('num_names', 1);
    }

  for ($i = 0; $i < $form_state->get('num_names'); $i++) {
      $form['typography']['names_fieldset'][$i]['first_name'] = [
        '#type' => 'textfield',
        '#title' => t('First name'),
        '#maxlength' => 64,
        '#size' => 64,
        '#prefix' => "<div class='inner-fieldset'><legend><span class='fieldset-legend'>People {$i}</span></legend>"
      ];
    }
      $form['typography']['names_fieldset']['actions'] = [
        '#type' => 'actions',
      ];
      $form['typography']['names_fieldset']['actions']['add_name'] = [
        '#type' => 'submit',
        '#value' => t('Add one more'),
        '#submit' => array('addOne'),
        '#ajax' => [
          'callback' => 'addmoreCallback',
          'wrapper' => "names-fieldset-wrapper",
        ],
      ];
     if ($form_state->get('num_names') > 1) {
        $form['typography']['names_fieldset']['actions']['remove_name'] = [
          '#type' => 'submit',
          '#value' => t('Remove one'),
          '#submit' => array('removeCallback'),
          '#ajax' => [
            'callback' => 'addmoreCallback',
            'wrapper' => "names-fieldset-wrapper",
          ],
        ];
    }
}

function addmoreCallback(array $form, FormStateInterface $form_state){
  $name_field = $form_state->get('num_names');
  return $form['typography']['names_fieldset'];
}
function addOne(array &$form, FormStateInterface $form_state) {
    $name_field = $form_state->get('num_names');
    $add_button = $name_field + 1;
    $form_state->set('num_names', $add_button);
    $form_state->setRebuild();
}
function removeCallback(array &$form, FormStateInterface $form_state) {
    $name_field = $form_state->get('num_names');
    if ($name_field > 1) {
      $remove_button = $name_field - 1;
      $form_state->set('num_names', $remove_button);
    }
    $form_state->setRebuild();
}
