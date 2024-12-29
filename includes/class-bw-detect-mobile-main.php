<?php 
namespace BW_Detect_Mobile;

class Main {
    protected string $version = BW_Detect_Mobile_VERSION;
    private static $instance = null;
    private $detector;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Charger les helpers avant l'autoloader
        require_once BW_Detect_Mobile_DIR . 'includes/helpers.php';
        
        $this->setup_autoloader();
        
        add_action('init', [$this, 'init'], 20);
        add_action('plugins_loaded', [$this, 'load_plugin_textdomain']);
    }

    private function setup_autoloader() {
        spl_autoload_register(function ($class) {
            $prefix = 'BW_Detect_Mobile\\';
            
            if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
                return;
            }

            $relative_class = substr($class, strlen($prefix));
            $file_name = strtolower(str_replace('_', '-', $relative_class));
            $file = BW_Detect_Mobile_DIR . 'includes/class-bw-detect-mobile-' . $file_name . '.php';

            if (file_exists($file)) {
                require_once $file;
            }
        });
    }

    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'bw-detect-mobile',
            false,
            dirname(plugin_basename(BW_Detect_Mobile_FILE)) . '/languages/'
        );
    }

    public function init() {
        try {
            // Vérifier que les fichiers requis existent
            if (!file_exists(BW_Detect_Mobile_DIR . 'Mobile-Detect/standalone/autoloader.php')) {
                throw new \Exception('Mobile-Detect library not found');
            }

            // Initialiser le détecteur
            $this->detector = new \BW_Detect_Mobile\Start();
            $detection_instance = $this->detector->init();

            // Initialiser Bricks immédiatement si disponible
            if (defined('BRICKS_VERSION')) {
                
                if ($detection_instance && isset($detection_instance['detection'])) {
                    new \BW_Detect_Mobile\Bricks($detection_instance['detection']);
                }
            }

        } catch (\Exception $e) {
            error_log("BW Detect Mobile Error: " . $e->getMessage());
        }
    }
  
    public function init_bricks($detection_instance) {
        if (!defined('BRICKS_VERSION')) {
            return;
        }
        
        if ($detection_instance && isset($detection_instance['detection'])) {
            
            // Initialiser une seule fois
            static $initialized = false;
            if (!$initialized) {
                new \BW_Detect_Mobile\Bricks($detection_instance['detection']);
                $initialized = true;
            }
        }
    }

    public static function get_detector() {
        static $detector = null;
        
        if ($detector === null) {
            $start = new \BW_Detect_Mobile\Start();
            $instance = $start->init();
            $detector = $instance['detection'] ?? null;
        }
        
        return $detector;
    }

    function bw_detect() {
        return \BW_Detect_Mobile\Main::get_detector();
    }
}
