<?php 
//Common includes for all main PHP pages(controllers)
/*
*Form helper functions

A collection of helper functions for 
forms , such as setValue()
*/


/**
 * set an HTML-safe value attribute of a form field form $_POST data 
 *
 * @param string $fieldName the name of the field to display 
 * @return string The HTML entity encoded output for the form field.
 */
function setValue($fieldName)
{
    //Get valeu form $_POST and encode it for HTML output 
    $encodedValue = htmlspecialchars($_POST[$fieldName] ?? "");

    //Return value="..."
    return "value='$encodedValue'";
}


/**
 * Returns an HTML-safe textarea value of a form field drom $_POST data. 
 *
 * @param string $fieldName the name of the field to display 
 * @return string The HTML entity encoded output for the form field.
 */
function setTextbox($fieldname)
{
    // Get value from $_POST and encode it for HTML output
    return htmlspecialchars($_POST[$fieldname] ?? "");
}


/**
 * Returns an "checked" attribute if the field value is checked/selected
 *
 * @param string $fieldName the name of the field to check 
 * @param string $fieldValue the value of the field to check 
 * @return string The "checked" attribute if field is checked /selected, otherwise empty string.
 */
function setChecked($fieldName, $fieldValue)
{
    //terrnary operator : condition? true : false
    return ($_POST[$fieldName] ?? null ) === $fieldValue ? "checked" : "";

}



/**
 * Returns an "checked" attribute if the field value is checked/selected
 *
 * @param string $fieldName the name of the field to check 
 * @param string $fieldValue the value of the field to check 
 * @return string The "selected" attribute if field is checked /selected, otherwise empty string.
 */
function setSelected($fieldName, $fieldValue)
{
    //terrnary operator : condition? true : false
    return ($_POST[$fieldName] ?? null ) === $fieldValue ? "selected" : "";

}