<?php

namespace Gdk
;

    class Pixbuf
    {
        /**
         * FFI Instance.
         */
        protected $ffi = '';

        /**
         * Gtk Instance.
         */
        public $cdata_instance = '';

        public function __construct()
        {
            // Get instance of FFI
            $this->ffi = \Gtk::getFFI();
        }

        public static function new_from_file($path)
        {
            $pixbuf = \Gtk::getFFI()->gdk_pixbuf_new_from_file($path, null);

            $object = new \Gdk\Pixbuf();
            $object->cdata_instance = $pixbuf;

            return $object;
        }

        public function __get($name)
        {
            if ('button' == $name) {
                return $this->ffi->cast('GdkEventButton', $this->cdata_instance->button);
            } elseif ('key' == $name) {
                return $this->ffi->cast('GdkEventKey', $this->cdata_instance->button);
            }
        }
    }
