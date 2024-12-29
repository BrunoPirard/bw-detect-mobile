<?php
namespace BW_Detect_Mobile;

class Bricks {
    private $detection;

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

    public function add_condition_group($groups) {
        $groups[] = [
            'name' => 'bw_device_detection',
            'label' => esc_html__('Device Detection', 'bw-detect-mobile'),
        ];

        return $groups;
    }

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
