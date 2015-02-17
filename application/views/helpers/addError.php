<?php

$GLOBALS['__DF_ERRORS__'] = $this->errors;
function showError($fieldName) {
    global $__DF_ERRORS__;
    if (isset($__DF_ERRORS__) && array_key_exists($fieldName, $__DF_ERRORS__)) {
        echo '<span class="bg-danger text-danger">' . $__DF_ERRORS__[$fieldName] . '</span>';
    }
}
