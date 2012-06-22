<?php
  /**
   * @author CF Ingrams <cfi@dmu.ac.uk>
   * @copyright De Montfort University
   *
   * @package mcrypt
   */

  class McryptResultValidate
  {
    /**
     * @var array
     */
    private $c_arr_tainted;

    /**
     * @var array
     */
    private $c_arr_cleaned;

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
    /**
     *
     */
    public function __construct()
    {
      $this->c_arr_tainted = array();
      $this->c_arr_cleaned = array();
    }

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
    public function __destruct() {}

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
    /**
     * @return array
     */
    public function get_sanitised_input()
    {
      return $this->c_arr_cleaned;
    }

// ~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*
    /**
     *
     */
    public function do_sanitise_input()
    {
      $this->c_arr_tainted = $_POST;
      $this->c_arr_cleaned['validate_error'] = false;
      $m_error_count = 0;
      $m_max_input_string_length = MAX_INPUT_STRING_LENGTH;

      $m_tainted_text_string = $this->c_arr_tainted['string-to-encrypt'];
      $m_decoded_text_string = html_entity_decode($m_tainted_text_string);

      $m_sanitised_text_string = filter_var($m_decoded_text_string, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

      if (empty($m_sanitised_text_string))
      {
        $m_error_count++;
      }

      if (strlen($m_sanitised_text_string) > $m_max_input_string_length)
      {
        $m_error_count++;
      }

      if ($m_error_count > 0)
      {
        $this->c_arr_cleaned['validate_error'] = true;
      }
      else
      {
        $this->c_arr_cleaned['sanitised_text_string'] = $m_sanitised_text_string;
      }
    }
  }
?>
