<?php
/**
 * Helper file for loading TrioFramework classes
 * @package 3oFramework
 * @subpackage Core
 * @author Cornel Borină <cornel@scoalaweb.com>
 */
if (!defined("TRIO_DIR"))  
{  
    define("TRIO_DIR", __DIR__);  
} 
// get the whereis class
include_once TRIO_DIR.'/whereis.php';

// get the core classes
require_once TRIO_DIR . '/framework-core.php';

// register other framework classes
Whereis::register(array (
  'CSSAtribute' => TRIO_DIR.'/css/CSSAtribute.php',
  'CSSColor' => TRIO_DIR.'/css/CSSColor.php',
  'CSSGradient' => TRIO_DIR.'/css/CSSGradient.php',
  'CSSUnit' => TRIO_DIR.'/css/CSSUnit.php',
  'Style' => TRIO_DIR.'/css/Style.php',
  'DBModel' => TRIO_DIR.'/db/DBModel.php',
  'TMysql' => TRIO_DIR.'/db/mysql/TMysql.php',
  'UserInputException' => TRIO_DIR.'/exceptions/UserInputException.php',
  'GenerateWhereis' => TRIO_DIR.'/GenerateWhereis.php',
  'Element' => TRIO_DIR.'/html/Element.php',
  'DefinitionList' => TRIO_DIR.'/html/elements/DefinitionList.php',
  'DescriptionList' => TRIO_DIR.'/html/elements/DescriptionList.php',
  'HtmlBlock' => TRIO_DIR.'/html/elements/HtmlBlock.php',
  'HtmlHeading' => TRIO_DIR.'/html/elements/HtmlHeading.php',
  'HtmlImage' => TRIO_DIR.'/html/elements/HtmlImage.php',
  'HtmlInline' => TRIO_DIR.'/html/elements/HtmlInline.php',
  'HtmlList' => TRIO_DIR.'/html/elements/HtmlList.php',
  'Link' => TRIO_DIR.'/html/elements/Link.php',
  'Paragraph' => TRIO_DIR.'/html/elements/Paragraph.php',
  'ScriptHead' => TRIO_DIR.'/html/elements/ScriptHead.php',
  'Table' => TRIO_DIR.'/html/elements/Table.php',
  'Button' => TRIO_DIR.'/html/forms/Button.php',
  'CheckableFormElements' => TRIO_DIR.'/html/forms/CheckableFormElements.php',
  'Checkbox' => TRIO_DIR.'/html/forms/Checkbox.php',
  'CheckboxGroup' => TRIO_DIR.'/html/forms/CheckboxGroup.php',
  'Form' => TRIO_DIR.'/html/forms/Form.php',
  'FormElement' => TRIO_DIR.'/html/forms/FormElement.php',
  'FormLabel' => TRIO_DIR.'/html/forms/FormLabel.php',
  'Hidden' => TRIO_DIR.'/html/forms/Hidden.php',
  'HtmlDropdown' => TRIO_DIR.'/html/forms/HtmlDropdown.php',
  'HtmlRadio' => TRIO_DIR.'/html/forms/HtmlRadio.php',
  'Input' => TRIO_DIR.'/html/forms/Input.php',
  'PasswordField' => TRIO_DIR.'/html/forms/PasswordField.php',
  'RadioGroup' => TRIO_DIR.'/html/forms/RadioGroup.php',
  'Textarea' => TRIO_DIR.'/html/forms/Textarea.php',
  'TextField' => TRIO_DIR.'/html/forms/TextField.php',
  'ToggleField' => TRIO_DIR.'/html/forms/ToggleField.php',
  'UploadForm' => TRIO_DIR.'/html/forms/UploadForm.php',
  'HtmlElement' => TRIO_DIR.'/html/HtmlElement.php',
  'TrioMail' => TRIO_DIR.'/utils/TrioMail.php',
  'TrioMailSMTP' => TRIO_DIR.'/utils/TrioMailSMTP.php',
  'TrioTimestamp' => TRIO_DIR.'/utils/TrioTimestamp.php',
));
