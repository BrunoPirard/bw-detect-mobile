<?php
namespace BW_Detect_Mobile;

use Detection\Exception\MobileDetectException;
use Detection\MobileDetectStandalone;

class Start {
    private $detection;


    /**
     * Constructor
     *
     * Initializes the Mobile Detect library.
     *
     * @since 0.3.0
     *
     * @return void
     */
    public function __construct() {
        $plugin_path = BW_Detect_Mobile_DIR;

        require_once $plugin_path . 'Mobile-Detect/standalone/autoloader.php';
        require_once $plugin_path . 'Mobile-Detect/src/MobileDetectStandalone.php';

        try {
            $this->detection = new MobileDetectStandalone();
            $this->detection->setUserAgent($_SERVER['HTTP_USER_AGENT'] ?? 'iPad');
        } catch (MobileDetectException $e) {
            error_log('Mobile Detect Error: ' . $e->getMessage());
        }
    }

    /**
     * Initialize the mobile detection instance.
     *
     * If the detection instance wasn't initialized yet, it will be
     * initialized and returned as an array.
     *
     * The returned array contains two elements:
     * - 'detection': The MobileDetectStandalone instance.
     * - 'isMobile': The result of the isMobile() method.
     *
     * If the detection instance couldn't be initialized, the method
     * will return false.
     *
     * @since 0.1.0
     *
     * @return array|false The detection instance and its result, or false.
     */
    public function init() {
        try {
            return [
                'detection' => $this->detection,
                'isMobile' => $this->detection->isMobile()
            ];
        } catch (MobileDetectException $e) {
            error_log('Mobile Detect Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Retrieves the mobile detection instance.
     *
     * @since 0.1.0
     *
     * @return MobileDetectStandalone|null The detection instance if available, or null if not initialized.
     */
    public function getDetection() {
        return $this->detection;
    }
}
