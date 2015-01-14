<?php if (!defined('FW')) die('Forbidden');

class FW_Extension_Wpcf7 extends FW_Extension
{

    /**
     * @internal
     */
    public function _init()
    {
    }

    public function getForms()
    {
        if (!class_exists("WPCF7_ContactForm")) {
            return array();
        }


        $forms = WPCF7_ContactForm::find();
        $results = array();
        foreach ($forms as $form) {
                $results[$form->id()] = $form->title();
        }
        return $results;
    }
}
