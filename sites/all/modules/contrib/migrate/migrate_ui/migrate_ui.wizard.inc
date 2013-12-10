<?php

/**
 * @file
 * Migration wizard framework.
 */

/**
 * The primary formbuilder function for the wizard form.
 *
 * This form has two defined submit handlers to process the different steps:
 *  - Previous: handles the way to get back one step in the wizard.
 *  - Next:     handles each step form submission,
 *
 * The third handler, the finish button handler, is the default form _submit
 * handler used to process the information.
 *
 * @param string $class_name
 *  Name of the MigrateUIWizard clsas for this wizard.
 */
function migrate_ui_wizard($form, &$form_state, $class_name = '') {
  // Rather than track state in $form_state, we simply keep our wizard
  // instance there, and it encapsulates all the state. We just need
  // to create the instance the first time in, and it will be serialized
  // between steps.
  if (empty($form_state['wizard'])) {
    $wizard = new $class_name();
    $form_state['wizard'] = $wizard;
  }

  // Fetch the form for the wizard's current step.
  $form = $form_state['wizard']->form($form_state);

  return $form;
}

/**
 * Submit handler for the "previous" button. Moves the wizard back to the
 * previous step, and retrieves the values that were submitted on that step.
 *
 * @todo: Can we remove steps that were dynamically added?
 */
function migrate_ui_wizard_previous_submit($form, &$form_state) {
  $form_state['wizard']->gotoPreviousStep($form_state);
}

/**
 * Validate handler for the 'next' button. Dispatches to the wizard's current
 * step for validation.
 */
function migrate_ui_wizard_next_validate($form, &$form_state) {
  $form_state['wizard']->formValidate($form_state);
}

/**
 * Submit handler for the 'next' button. Saves the form values for the step
 * we're leaving, so Previous can pick them up, and moves the wizard to the
 * next step.
 */
function migrate_ui_wizard_next_submit($form, &$form_state) {
  $form_state['wizard']->gotoNextStep($form_state);
}

/**
 * Submit handler for the Save settings button. Register the migrations that were
 * (implicitly) defined along the way and redirect to the Migrate dashboard.
 */
function migrate_ui_wizard_submit($form, &$form_state) {
  $form_state['wizard']->formSaveSettings();
  $form_state['redirect'] = 'admin/content/migrate/groups/' . $form_state['wizard']->getGroupName();
}

/**
 * Submit handler for the "Save settings and import" button. Register the
 * migrations that were (implicitly) defined along the way, run the import, and
 * redirect to the Migrate dashboard.
 */
function migrate_ui_wizard_migrate_submit($form, &$form_state) {
  $form_state['wizard']->formSaveSettings();
  $form_state['wizard']->formPerformImport();
}

/**
 * The base class for migration wizards. Extend this class to implement a
 * wizard UI for importing into Drupal from a given source format (Drupal,
 * WordPress, etc.).
 */
abstract class MigrateUIWizard {
  /**
   * We maintain a doubly-linked list of wizard steps, both to support
   * previous/next, and to easily insert steps dynamically.
   *
   * The first step of the wizard, which has no predecessor. Will generally be
   * an overview/introductory page.
   *
   * @var MigrateUIStep
   */
  protected $firstStep;

  /**
   * The last step of the wizard, which has no successor. Will generally be a
   * review page.
   *
   * @var MigrateUIStep
   */
  protected $lastStep;

  /**
   * The current step of the wizard (the one being shown in the UI, and the one
   * whose button is being clicked on).
   *
   * @var MigrateUIStep
   */
  protected $currentStep;

  /**
   * The step number, used in the page title.
   *
   * @var int
   */
  protected $stepNumber = 1;

  /**
   * The group name to assign to any Migration instances created.
   *
   * @var string
   */
  protected $groupName = 'default';
  public function getGroupName() {
    return $this->groupName;
  }

  /**
   * The user-visible title of the group.
   *
   * @var string
   */
  protected $groupTitle = 'default';

  /**
   * Any arguments that apply to all migrations in the group.
   *
   * @var array
   */
  protected $groupArguments = array();

  /**
   * Array of Migration argument arrays, keyed by machine name. On Finish, used
   * to register Migrations.
   *
   * @var array
   */
  protected $migrations = array();

  /**
   * Returns the translatable name representing the source of the data (e.g.,
   * "Drupal", "WordPress", etc.).
   *
   * @return string
   */
  abstract public function getSourceName();

  public function __construct() {}

  /**
   * Add a step to the wizard.
   *
   * @param string $name
   *  Translatable name for the step, to be used in the page title.
   * @param string $form_method
   *  MigrateUIWizard method returning the form array for the step.
   * @param MigrateUIStep $after
   *  Optional step after which to insert the new step. If omitted, add it at
   *  the end.
   * @param mixed $context
   *  Optional data to be used by this step's form.
   *
   * @return MigrateUIStep
   */
  protected function addStep($name, $form_method, MigrateUIStep $after = NULL, $context = NULL) {
    $new_step = new MigrateUIStep($name, $form_method, $context);
    // There were no steps, so this is the only one.
    if (is_null($this->firstStep)) {
      $this->firstStep = $this->lastStep = $this->currentStep = $new_step;
    }
    else {
      // If no insertion point is specified, append to the end.
      if (is_null($after)) {
        $after = $this->lastStep;
      }
      // Do the insert, rewriting the links appropriately.
      $new_step->nextStep = $after->nextStep;

      if (is_null($new_step->nextStep)) {
        $this->lastStep = $new_step;
      }
      else {
        $new_step->nextStep->previousStep = $new_step;
      }
      $new_step->previousStep = $after;
      $after->nextStep = $new_step;
    }
    return $new_step;
  }

  /**
   * Move the wizard to the next step in line (if any), first squirreling away
   * the current step's form values.
   */
  public function gotoNextStep(&$form_state) {
    if ($this->currentStep && $this->currentStep->nextStep) {
      $this->currentStep->setFormValues($form_state['values']);
      $form_state['rebuild'] = TRUE;
      $this->currentStep = $this->currentStep->nextStep;
      $this->stepNumber++;
    }
  }

  /**
   * Move the wizard to the previous step in line (if any), restoring its
   * form values.
   */
  public function gotoPreviousStep(&$form_state) {
    if ($this->currentStep && $this->currentStep->previousStep) {
      $this->currentStep = $this->currentStep->previousStep;
      $this->stepNumber--;
      $form_state['values'] = $this->currentStep->getFormValues();
      $form_state['rebuild'] = TRUE;
    }
  }

  /**
   * Build the form for the current step.
   *
   * @return array
   */
  public function form(&$form_state) {
    drupal_set_title(t('Import from @source_title',
      array('@source_title' => $this->getSourceName())));

    $form_method = $this->currentStep->getFormMethod();
    $form['title'] = array(
      '#prefix' => '<h2>',
      '#markup' => t('Step @step: @step_name',
          array(
                '@step' => $this->stepNumber,
                '@step_name' => $this->currentStep->getName())),
      '#suffix' => '</h2>',
    );

    $form += $this->{$form_method}($form_state);

    $form['actions'] = array('#type' => 'actions');

    // Show the 'previous' button if appropriate. Note that #submit is set to
    // a special submit handler, and that we use #limit_validation_errors to
    // skip all complaints about validation when using the back button. The
    // values entered will be discarded, but they will not be validated, which
    // would be annoying in a "back" button.
    if ($this->currentStep != $this->firstStep) {
      $form['actions']['prev'] = array(
        '#type' => 'submit',
        '#value' => t('Previous'),
        '#name' => 'prev',
        '#submit' => array('migrate_ui_wizard_previous_submit'),
        '#limit_validation_errors' => array(),
      );
    }

    // Show the Next button only if there are more steps defined.
    if ($this->currentStep == $this->lastStep) {
      $form['actions']['finish'] = array(
        '#type' => 'submit',
        '#value' => t('Save import settings'),
      );
/*
      $form['actions']['migrate'] = array(
        '#type' => 'submit',
        '#value' => t('Save settings and import'),
        '#submit' => array('migrate_ui_wizard_migrate_submit'),
      );*/
    }
    else {
      $form['actions']['next'] = array(
        '#type' => 'submit',
        '#value' => t('Next'),
        '#name' => 'next',
        '#submit' => array('migrate_ui_wizard_next_submit'),
        '#validate' => array('migrate_ui_wizard_next_validate'),
      );
    }
    return $form;
  }

  /**
   * Call the validation function for the current form (which has the same
   * name of the form function with 'Validate' appended).
   *
   * @param array $form_state
   */
  public function formValidate(&$form_state) {
    $validate_method = $this->currentStep->getFormMethod() . 'Validate';
    $this->{$validate_method}($form_state);
  }

  /**
   * Take the information we've accumulated throughout the wizard, and create
   * the Migrations to perform the import.
   */
  public function formSaveSettings() {
    MigrateGroup::register($this->groupName, $this->groupTitle, $this->groupArguments);
    $info['arguments']['group_name'] = $this->groupName;
    foreach ($this->migrations as $machine_name => $info) {
      // Call the right registerMigration implementation. Note that this means
      // that classes that override registerMigration() must handle registration
      // themselves, they cannot leave it to us and expect their extension to be
      // called.
      if (is_subclass_of($info['class_name'], 'Migration')) {
        Migration::registerMigration($info['class_name'], $machine_name,
                $info['arguments']);
      }
      else {
        MigrationBase::registerMigration($info['class_name'], $machine_name,
                $info['arguments']);
      }
    };
    menu_rebuild();
  }

  /**
   * Run the import process for the migration group we've defined.
   */
  public function formPerformImport() {

  }

  /**
   * Record all the information necessary to register a migration when this is
   * all over.
   *
   * @param string $machine_name
   *  Machine name for the migration class.
   * @param string $class_name
   *  Name of the Migration class to instantiate.
   * @param array $arguments
   *  Further information configuring the migration.
   */
  protected function addMigration($machine_name, $class_name, $arguments) {
    $machine_name = $this->groupName . $machine_name;
    if (isset($arguments['dependencies'])) {
      foreach ($arguments['dependencies'] as $index => $dependency) {
        $arguments['dependencies'][$index] = $this->groupName . $dependency;
      }
    }
    if (isset($arguments['soft_dependencies'])) {
      foreach ($arguments['soft_dependencies'] as $index => $dependency) {
        $arguments['soft_dependencies'][$index] = $this->groupName . $dependency;
      }
    }
    $arguments += array(
      'group_name' => $this->groupName,
      'machine_name' => $machine_name,
    );
    $this->migrations[$machine_name] = array(
      'class_name' => $class_name,
      'arguments' => $arguments,
    );
  }
}

/**
 * Class representing one step of a wizard.
 */
class MigrateUIStep {
  /**
   * A translatable string briefly describing this step, to be used in the page
   * title for the step form.
   *
   * @var string
   */
  protected $name;
  public function getName() {
    return $this->name;
  }

  /**
   * The name of the MigrateUIWizard method returning the form array for this
   * step.
   *
   * @var string
   */
  protected $form_method;
  public function getFormMethod() {
    return $this->form_method;
  }

  /**
   * The form values ($form_state['values']) submitted for this step, saved in
   * case we need to restore them on a Previous action.
   *
   * @var array
   */
  protected $formValues;
  public function getFormValues() {
    return $this->formValues;
  }
  public function setFormValues($form_values) {
    $this->formValues = $form_values;
  }

  /**
   * Any contextual data needed by the form for this step. For example, a
   * field mapping form would need to know the source and destination content
   * types so it can determine what fields to expose.
   *
   * @var mixed
   */
  protected $context;
  public function getContext() {
    return $this->context;
  }

  /**
   * The step object is a node in a doubly-linked list - it links to its
   * predecessor and successor steps.
   *
   * @var MigrateUIStep
   */
  public $nextStep;

  /**
   * @var MigrateUIStep
   */
  public $previousStep;

  public function __construct($name, $form_method, $context = NULL) {
    $this->name = $name;
    $this->form_method = $form_method;
    $this->context = $context;
  }
}
