<?php

/**
 * Create a text input field for the registration form.
 */
function create_form_field(string $name, array $specs): string {
    global $errors, $inputs;

    $value = $inputs[$name] ?? '';
    $error = $errors[$name] ?? '';
    $type = $specs['type'] ?? 'text';
    $label = $specs['label'] ?? '';
    $placeholder = $specs['placeholder'] ?? '';
    $options = $specs['options'] ?? [];
    $required = strpos($specs['rule'] ?? '', 'required') ? '<span class="req">*</span>' : '';
    $error_class = error_class($errors, $name);

    $output = PHP_EOL . '    <div>';
    $output .= PHP_EOL . '        <label for="' . $name . '">';
    if ($type === "checkbox") {
        $output .= PHP_EOL . '            <input type="' . $type . '" name="' . $name . '" id="' . $name . '" value="checked" class="' . $error_class . '" ' . $value . '>';
        $output .= PHP_EOL . '            ' . $label . $required;
        $output .= PHP_EOL . '        </label>';
    } elseif ($type == "select") {
        $output .= "$label$required</label>";
        $output .= PHP_EOL . '        <select name="' . $name . '" id="' . $name . '">';
        foreach ($options as $value => $option) {
            $output .= PHP_EOL . '            <option value="' . $value . '">' . $option . '</option>';
        }
        $output .= PHP_EOL . '        </select>';
    } else {
        $output .= "$label$required</label>";
        $output .= PHP_EOL . '        <input type="' . $type . '" name="' . $name . '" id="' . $name . '" placeholder="' . $placeholder . '" value="' . $value . '" class="' . $error_class . '">';
    }
    $output .= PHP_EOL . "        <small>$error</small>";
    $output .= PHP_EOL . "    </div>";
    return $output;
}
