The hydrology_model module provides a representation for models within the hydroshare environment.  It consists of two primary files:

hydrology_model.module - The entry point for the model resource.  This module creates hydroshare model resources from parsed model data.
hydrology_model.info - A drupal info file describing the module.

Supplimentary php scripts are added to the "parsers" directory to provide model specific data parsing.  These "plugin" scripts are automatically detected, and should be designed to provide input/output parsing capabilities for a single model.  Since these php scripts are treated as plugins, they must follow a strict coding convention:

1.) The name of the php script must be "ModelName" followed by "parser.php", omitting any special characters and spaces.  e.g. HECRAS_parser.php, SWAT_parser.php.

2.) The php script must contain a class that has the same name as the "ModelName".  e.g. SWAT_parser.php must contain a class named SWAT.

3.) This class must have a function called parse_metadata($form, &$form_state, $model_path)

4.) This class can optionally have a function called get_single_output($node, $model_path) for providing single output data visualization
