<?php
// Register Doctor CPT
function register_doctor_cpt() {
    register_post_type('doctor', array(
        'label' => 'Doctors',
        'public' => true,
        'supports' => array('title', 'editor', 'custom-fields'),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-id',
    ));
}
add_action('init', 'register_doctor_cpt');

// Register Appointment CPT
function register_appointment_cpt() {
    register_post_type('appointment', array(
        'label' => 'Appointments',
        'public' => false,
        'supports' => array('title', 'custom-fields'),
        'show_ui' => true,
        'show_in_rest' => true,
    ));
}
add_action('init', 'register_appointment_cpt');

// Add Meta Box for Doctor Schedule
function doctor_schedule_meta_box() {
    add_meta_box(
        'doctor_schedule',
        'Doctor Schedule',
        'doctor_schedule_meta_box_callback',
        'doctor',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'doctor_schedule_meta_box');

function doctor_schedule_meta_box_callback($post) {
    $schedule = get_post_meta($post->ID, 'doctor_schedule', true);
    if (!is_array($schedule)) {
        $schedule = array(
            'mon' => '', 'tue' => '', 'wed' => '', 'thu' => '', 'fri' => '', 'sat' => '', 'sun' => ''
        );
    }
    $days = array('mon'=>'Monday','tue'=>'Tuesday','wed'=>'Wednesday','thu'=>'Thursday','fri'=>'Friday','sat'=>'Saturday','sun'=>'Sunday');
    foreach ($days as $key => $label) {
        echo '<label>' . $label . ':</label> ';
        echo '<input type="text" name="doctor_schedule[' . $key . ']" value="' . esc_attr($schedule[$key]) . '" placeholder="e.g. 09:00-12:00, 13:00-17:00" style="width:70%" /><br>';
    }
    echo '<p>Enter time slots for each day, separated by commas.</p>';
}

function save_doctor_schedule_meta($post_id) {
    if (isset($_POST['doctor_schedule'])) {
        update_post_meta($post_id, 'doctor_schedule', $_POST['doctor_schedule']);
    }
}
add_action('save_post_doctor', 'save_doctor_schedule_meta');

// Shortcode to Display All Doctors and Their Schedules
function doctors_list_shortcode() {
    $args = array('post_type' => 'doctor', 'posts_per_page' => -1);
    $doctors = get_posts($args);
    if (!$doctors) return '<p>No doctors found.</p>';
    $output = '<div class="doctors-list">';
    foreach ($doctors as $doctor) {
        $schedule = get_post_meta($doctor->ID, 'doctor_schedule', true);
        $output .= '<div class="doctor">';
        $output .= '<h3>' . esc_html($doctor->post_title) . '</h3>';
        $output .= '<div>' . apply_filters('the_content', $doctor->post_content) . '</div>';
        $output .= '<ul>';
        $days = array('mon'=>'Monday','tue'=>'Tuesday','wed'=>'Wednesday','thu'=>'Thursday','fri'=>'Friday','sat'=>'Saturday','sun'=>'Sunday');
        foreach ($days as $key => $label) {
            $output .= '<li><strong>' . $label . ':</strong> ' . (!empty($schedule[$key]) ? esc_html($schedule[$key]) : 'Not available') . '</li>';
        }
        $output .= '</ul></div>';
    }
    $output .= '</div>';
    return $output;
}
add_shortcode('doctors_list', 'doctors_list_shortcode');