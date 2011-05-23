<?php
class cpDatePickerWidget extends sfWidgetFormInput {

  /**
   * Constructor.
   *
   * Available options:
   *
   *  * type: The widget type (text by default)
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array()) {
    $this->addRequiredOption('culture');
    $this->addOption('dateFormat', 'yyyy.mm.dd');
    $this->addOption('startDate', '1901-01-01');
    $this->addOption('endDate');
    $this->addOption('clickInput', true);
    $this->addOption('template', <<<EOF
%widget%
<script type="text/javascript">
  jQuery(document).ready(function() {
    Date.format = '%date_format%';
    jQuery('#%id%').datePicker({
      startDate: '%start_date%',
      endDate: '%end_date%',
      clickInput: %click_input%
    });
  });
</script>    
EOF
);
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array()) {
    $id = $this->generateId($name);

    return strtr($this->getOption('template'), array(
             '%widget%' => parent::render($name, $value, $attributes, $errors),
             '%id%' => $id,
             '%date_format%' => $this->getOption('dateFormat'),
             '%start_date%' => $this->getOption('startDate'),
             '%end_date%' => $this->getOption('endDate'),
             '%click_input%' => $this->getOption('clickInput')
            ));
  }
  
  public function getJavascripts() {
    return array('/cpDatePickerPlugin/js/date.js',
                 '/cpDatePickerPlugin/js/date_' . $this->getOption('culture') . '.js',
                 '/cpDatePickerPlugin/js/jquery.datePicker.js');
  }
  
  public function getStylesheets() {
    return array('/cpDatePickerPlugin/css/datePicker.css' => 'all');
  }
}