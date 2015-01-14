<?php if (!defined('FW')) die('Forbidden');

class FW_Extension_Gravity extends FW_Extension
{

    /**
     * @internal
     */
    public function _init()
    {
    }

    public function getForms()
    {
        if (!class_exists("RGFormsModel")) {
            return array();
        }

        $forms = RGFormsModel::get_forms(null, "title");

        $results = array();

        foreach ($forms as $form) {
            if ($form->is_active !== "1") {
                continue;
            }
            $results[$form->id] = $form->title;
        }

        return $results;
    }
}
