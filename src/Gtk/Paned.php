<?php

namespace Gtk
;

    class paned extends Container
    {
        protected $name = 'GtkPaned';

        /**
         * GtkOrientation.
         */
        const ORIENTATION_HORIZONTAL = 0;
        const ORIENTATION_VERTICAL = 1;

        public function __construct(int $orientation = 0)
        {
            parent::__construct();

            // Create the window
            $this->cdata_instance = $this->ffi->gtk_paned_new($orientation);
        }

        public function __call($name, $value)
        {
            $function_name = 'gtk_paned_'.$name;

            try {
                if (0 == count($value)) {
                    $return = $this->ffi->$function_name($this->ffi->cast('GtkPaned *', $this->cdata_instance));
                } elseif (1 == count($value)) {
                    $return = $this->ffi->$function_name($this->ffi->cast('GtkPaned *', $this->cdata_instance), $value[0]);
                } elseif (2 == count($value)) {
                    $return = $this->ffi->$function_name($this->ffi->cast('GtkPaned *', $this->cdata_instance), $value[0], $value[1]);
                } elseif (3 == count($value)) {
                    $return = $this->ffi->$function_name($this->ffi->cast('GtkPaned *', $this->cdata_instance), $value[0], $value[1], $value[2]);
                } elseif (4 == count($value)) {
                    $return = $this->ffi->$function_name($this->ffi->cast('GtkPaned *', $this->cdata_instance), $value[0], $value[1], $value[2], $value[3]);
                }
            } catch (\FFI\Exception $e) {
                $return = parent::__call($name, $value);
            }

            return $this->parse_variable($return);
        }

        public function get_position()
        {
            $pos = $this->ffi->gtk_paned_get_position($this->ffi->cast('GtkPaned *', $this->cdata_instance));

            $this->parse_variable($pos);

            return $pos;
        }

        public function add1(Widget $child)
        {
            $this->ffi->gtk_paned_add1($this->ffi->cast('GtkPaned *', $this->cdata_instance), $child->cdata_instance);
        }

        public function add2(Widget $child)
        {
            $this->ffi->gtk_paned_add1($this->ffi->cast('GtkPaned *', $this->cdata_instance), $child->cdata_instance);
        }

        public function pack1(Widget $child, bool $resize = false, bool $shrink = false)
        {
            $this->ffi->gtk_paned_pack1($this->ffi->cast('GtkPaned *', $this->cdata_instance), $child->cdata_instance, $resize, $shrink);
        }

        public function pack2(Widget $child, bool $resize = false, bool $shrink = false)
        {
            $this->ffi->gtk_paned_pack2($this->ffi->cast('GtkPaned *', $this->cdata_instance), $child->cdata_instance, $resize, $shrink);
        }

        public function get_child1()
        {
            $object = $this->ffi->gtk_paned_get_child1($this->ffi->cast('GtkPaned *', $this->cdata_instance));

            $this->parse_variable($object);

            return $this->PHPGTK_OBJECT($object);
        }

        public function get_child2()
        {
            $object = $this->ffi->gtk_paned_get_child2($this->ffi->cast('GtkPaned *', $this->cdata_instance));

            return $this->PHPGTK_OBJECT($object);
        }
    }
