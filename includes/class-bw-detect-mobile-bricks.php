<?php
namespace BW_Detect_Mobile;

class Bricks {
    private $detection;

    /**
     * Constructor
     *
     * @param Mobile_Detect $detection Mobile detection instance.
     *
     * @throws \Exception If the mobile detection instance is empty.
     */
    public function __construct($detection) {
        if (!$detection) {
            throw new \Exception('Mobile detection instance is required');
        }

        $this->detection = $detection;
        
        // Ajouter les trois filtres requis par Bricks
        add_filter('bricks/conditions/groups', [$this, 'add_condition_group']);
        add_filter('bricks/conditions/options', [$this, 'add_condition_options']);
        add_filter('bricks/conditions/result', [$this, 'check_condition'], 10, 3);

        // Exposer la fonction pour les code blocks
        add_filter('bricks/builder/code_functions', [$this, 'add_code_functions']);
    }

    /**
     * Adds code functions related to device detection to the provided array.
     *
     * Each function entry includes a name, description, and code example.
     * The functions added are:
     * - bw_detect: Provides access to the mobile detection library.
     * - bw_is_mobile: Checks if the device is mobile, excluding tablets.
     * - bw_is_tablet: Checks if the device is a tablet.
     * - bw_is_desktop: Checks if the device is a desktop.
     *
     * @param array $functions An array of functions to which the new functions will be added.
     * @return array The updated array containing the added functions.
     */
    public function add_code_functions($functions) {
        $functions[] = [
            'name' => 'bw_detect',
            'description' => 'Mobile Detection Library',
            'example' => "if (bw_detect()->isMobile()) {\n  // Code for mobile\n}",
        ];
        
        $functions[] = [
            'name' => 'bw_is_mobile',
            'description' => 'Check if device is mobile (excluding tablets)',
            'example' => "if (bw_is_mobile()) {\n  echo 'This is a mobile device';\n}",
        ];
        
        $functions[] = [
            'name' => 'bw_is_tablet',
            'description' => 'Check if device is tablet',
            'example' => "if (bw_is_tablet()) {\n  echo 'This is a tablet';\n}",
        ];
        
        $functions[] = [
            'name' => 'bw_is_desktop',
            'description' => 'Check if device is desktop',
            'example' => "if (bw_is_desktop()) {\n  echo 'This is a desktop';\n}",
        ];
        
        return $functions;
    }

    /**
     * Adds a new condition group for device detection to the provided groups array.
     *
     * The condition group added has a name 'bw_device_detection' and a label for display.
     *
     * @param array $groups An array of existing condition groups to which the new group will be added.
     * @return array The updated array of condition groups including the new device detection group.
     */
    public function add_condition_group($groups) {
        $groups[] = [
            'name' => 'bw_device_detection',
            'label' => esc_html__('Device Detection', 'bw-detect-mobile'),
        ];

        return $groups;
    }

    /**
     * Adds a new condition option for device detection to the provided options array.
     *
     * The condition option added has a key 'device_type' and a label for display.
     * It provides a select comparison with options 'is' and 'is_not'.
     * It also provides a select value with options 'mobile', 'tablet', and 'desktop'.
     *
     * @param array $options An array of existing condition options to which the new option will be added.
     * @return array The updated array of condition options including the new device detection option.
     */
    public function add_condition_options($options) {
        $options[] = [
            'key' => 'device_type',
            'label' => esc_html__('Device Type', 'bw-detect-mobile'),
            'group' => 'bw_device_detection',
            'compare' => [
                'type' => 'select',
                'options' => [
                    'is' => esc_html__('Is', 'bw-detect-mobile'),
                    'is_not' => esc_html__('Is Not', 'bw-detect-mobile'),
                ],
                'placeholder' => esc_html__('Select comparison', 'bw-detect-mobile'),
            ],
            'value' => [
                'type' => 'select',
                'options' => [
                    'mobile' => esc_html__('Mobile', 'bw-detect-mobile'),
                    'tablet' => esc_html__('Tablet', 'bw-detect-mobile'),
                    'desktop' => esc_html__('Desktop', 'bw-detect-mobile'),
                ],
                'placeholder' => esc_html__('Select device type', 'bw-detect-mobile'),
            ],
        ];

        return $options;
    }

    /**
     * Checks a condition provided in the $condition parameter and returns a boolean
     * result indicating whether the condition is matched or not.
     *
     * The condition is based on the current device type, and the comparison
     * parameter is either 'is' or 'is_not'. The value parameter is either
     * 'mobile', 'tablet', or 'desktop'.
     *
     * If the condition is not for device type, the method returns the $result
     * parameter unchanged.
     *
     * @param bool   $result     The current result of the condition check.
     * @param string $condition_key The key of the condition to check.
     * @param array  $condition The condition to check, containing the 'compare' and
     *                           'value' parameters.
     * @return bool The result of the condition check.
     */
    public function check_condition($result, $condition_key, $condition) {
        // Vérifier si c'est notre condition
        if ($condition_key !== 'device_type') {
            return $result;
        }

        $compare = isset($condition['compare']) ? $condition['compare'] : 'is';
        $device_type = isset($condition['value']) ? $condition['value'] : '';

        // Détecter le type d'appareil actuel
        $current_device = 'desktop'; // Par défaut
        if ($this->detection->isMobile() && !$this->detection->isTablet()) {
            $current_device = 'mobile';
        } elseif ($this->detection->isTablet()) {
            $current_device = 'tablet';
        }

        // Vérifier la condition
        $matches = ($current_device === $device_type);

        // Inverser le résultat si la comparaison est "is_not"
        return ($compare === 'is') ? $matches : !$matches;
    }
}
