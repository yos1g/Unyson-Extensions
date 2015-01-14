<?php if (!defined('FW')) die('Forbidden');

class FW_Extension_Gallery extends FW_Extension
{

    private $post_type = 'fw-gallery';

    private $multimedia_types = array('image', 'video');

    /**
     * @internal
     */
    public function _init()
    {
        if (is_admin()) {
            $this->add_admin_filters();
            $this->add_admin_actions();
        }
    }

    public function get_post_type()
    {
        return $this->post_type;
    }

    private function add_admin_filters()
    {
        add_filter('fw_post_options', array($this, '_admin_filter_load_options'), 10, 2);
    }

    public function _admin_filter_load_options($options, $post_type)
    {
        if ($post_type === $this->get_post_type()) {
            return $this->load_post_edit_options();
        }

        return $options;
    }

    public function load_post_edit_options()
    {
        $options = array_merge(
            $this->get_population_options()
        );

        return $options;
    }

    private function transform_multimedia_types_array($multimedia_types)
    {
        return array_combine(
            array_values($multimedia_types),
            array_map('ucfirst', $multimedia_types)
        );
    }

    public function get_population_options()
    {

        $media_type_choices = $this->transform_multimedia_types_array($this->multimedia_types);
        $media_type_values = array_keys($media_type_choices);
        $media_type_values = array_shift($media_type_values);

        $options = array(
            'wrapper-population-method-custom' => array(
                'title' => __('Click to edit / Drag to reorder <span class="fw-slide-spinner spinner"></span>', 'fw'),
                'type' => 'box',
                'options' => array(
                    'custom-slides' =>
                        array(
                            'label' => false,
                            'desc' => false,
                            'type' => 'slides',
                            'multimedia_type' => $media_type_values,
                            'thumb_size' => array('height' => 75, 'width' => 138),
                            'slides_options' => array(
                                'multimedia' => array(
                                    'type' => 'multi-picker',
                                    'desc' => false,
                                    'label' => false,
                                    'hide_picker' => true,
                                    'picker' => array(
                                        'selected' => array(
                                            'type' => 'radio',
                                            'attr' => array('class' => 'multimedia-radio-controls'),
                                            'label' => __('Choose ', 'fw'),
                                            'choices' => $media_type_choices,
                                            'value' => $media_type_values
                                        )),
                                    'choices' => $this->get_multimedia_types_sets($this->multimedia_types)
                                ),
                                'title' => array(
                                    'type' => 'text',
                                    'label' => __('Title', 'fw'),
                                ),
                                'desc' => array(
                                    'type' => 'textarea',
                                    'label' => __('Description', 'fw'),
                                    'value' => ''
                                ),
                                'product' => array(
                                    'type' => 'multi-select',
                                    'label' => __('Product', 'fw'),
                                    'population' => 'posts',
                                    'source' => 'product',
                                    'limit' => 100,
                                )
                            )
                        )
                )
            )
        );

        return $options;
    }

    private function get_multimedia_types_sets($multimedia_types)
    {
        $options = array(
            'image' => array(
                'src' => array(
                    'label' => __('Image', 'fw'),
                    'type' => 'upload',
                )
            ),
            'video' => array(
                'src' => array(
                    'label' => __('Video', 'fw'),
                    'type' => 'text'
                )
            ),
        );

        $filtered_options = array();

        $filtered_multimedia_types = array_intersect($this->multimedia_types, $multimedia_types);

        foreach ($filtered_multimedia_types as $multimedia_type) {
            $filtered_options[$multimedia_type] = $options[$multimedia_type];
        }

        return $filtered_options;
    }

    private function add_admin_actions()
    {
        add_action('admin_menu', array($this, '_admin_action_replace_submit_meta_box'));
    }

    public function _admin_action_replace_submit_meta_box()
    {
        remove_meta_box('submitdiv', $this->get_post_type(), 'core');
        add_meta_box('submitdiv', __('Publish', 'fw'), array($this, 'render_submit_meta_box'), $this->get_post_type(), 'side');
    }

    public function render_submit_meta_box($post, $args = array())
    {
        // a modified version of post_submit_meta_box() (wp-admin/includes/meta-boxes.php, line 12)
        $post_type = $post->post_type;
        $post_type_object = get_post_type_object($post_type);
        $can_publish = current_user_can($post_type_object->cap->publish_posts);
        $meta = fw_get_db_post_option($post->ID);
        echo $this->render_view('backend/submit-box-raw', compact('post', 'meta', 'post_type', 'post_type_object', 'can_publish'));
    }
}