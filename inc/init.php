<?php
/**
 * @package n9-reviews
 */

namespace Inc;

final class Init
{

    /**
     * Loop Through the classes, initialize and register them
     * @return
     */
    public static function register_services()
    {
        $services = self::get_services();

        if ($services) {
            foreach ($services as $service) {
                $service_obj = self::instantiate($service);

                if ($service_obj && method_exists($service_obj, 'register')) {
                    $service_obj->register();
                }
            }
        }
    }

    /**
     * stores an array service class
     * @return  array   service classes
     */
    public static function get_services()
    {
        return [
            Base\Enqueue::class,
            Pages\Dashboard::class,
            Base\ReviewsController::class,
            // Forms\ReviewForm::class,
            Widget\ReviewFormWidget::class
        ];
    }

    /**
     * Initialize the Class
     * @param  Class   A class to be instantiated
     * @return  Object  Instanitated Class object
     */
    public static function instantiate($class)
    {
        $service_obj =  new $class();
        return $service_obj;
    }
}
