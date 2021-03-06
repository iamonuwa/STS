<?php

/**
 * A base model with a series of CRUD functions (powered by CI's query builder),
 * validation-in-model support, event callbacks and more.
 *
 * @link http://github.com/jamierumbelow/codeigniter-base-model
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 * @copyright Copyright (c) 2014, Maintainer Bo-Yi Wu <http://blog.wu-boy.com>
 */

class MY_Model extends CI_Model
{
    /* --------------------------------------------------------------
     * VARIABLES
     * ------------------------------------------------------------ */

    /**
     * This model's default database table. Automatically
     * guessed by pluralising the model name.
     */
    protected $_table;

    /**
     * The database connection object. Will be set to the default
     * connection. This allows individual models to use different DBs
     * without overwriting CI's global $this->db connection.
     */
    public $_database;

    /**
     * This model's default primary key or unique identifier.
     * Used by the get(), update() and delete() functions.
     */
    protected $primary_key = 'id';

    /**
     * Support for soft deletes and this model's 'deleted' key
     */
    protected $soft_delete = false;
    protected $soft_delete_key = 'deleted';
    protected $_temporary_with_deleted = false;
    protected $_temporary_only_deleted = false;

    /**
     * The various callbacks available to the model. Each are
     * simple lists of method names (methods will be run on $this).
     */
    protected $before_create = [];
    protected $after_create = [];
    protected $before_update = [];
    protected $after_update = [];
    protected $before_get = [];
    protected $after_get = [];
    protected $before_delete = [];
    protected $after_delete = [];

    protected $callback_parameters = [];

    /**
     * Protected, non-modifiable attributes
     */
    protected $protected_attributes = [];

    /**
     * Relationship arrays. Use flat strings for defaults or string
     * => array to customise the class name and primary key
     */
    protected $belongs_to = [];
    protected $has_many = [];

    protected $_with = [];

    /**
     * An array of validation rules. This needs to be the same format
     * as validation rules passed to the Form_validation library.
     */
    protected $validate = [];

    /**
     * Optionally skip the validation. Used in conjunction with
     * skip_validation() to skip data validation for any future calls.
     */
    protected $skip_validation = false;

    /**
     * By default we return our results as objects. If we need to override
     * this, we can, or, we could use the `as_array()` and `as_object()` scopes.
     */
    protected $return_type = 'object';
    protected $_temporary_return_type = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /* --------------------------------------------------------------
     * GENERIC METHODS
     * ------------------------------------------------------------ */

    /**
     * Initialise the model, tie into the CodeIgniter superobject and
     * try our best to guess the table name.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('inflector');

        $this->_fetch_table();

        $this->_database = $this->db;

        array_unshift($this->before_create, 'protect_attributes');
        array_unshift($this->before_update, 'protect_attributes');

        $this->_temporary_return_type = $this->return_type;
    }

    /* --------------------------------------------------------------
     * CRUD INTERFACE
     * ------------------------------------------------------------ */

    /**
     * Fetch a single record based on the primary key. Returns an object.
     */
    public function get($primary_value)
    {
        return $this->get_by($this->primary_key, $primary_value);
    }

    /**
     * Fetch a single record based on an arbitrary WHERE call. Can be
     * any valid value to $this->_database->where().
     */
    public function get_by()
    {
        $where = func_get_args();

        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE) {
            $this->_database->where($this->soft_delete_key, (bool) $this->_temporary_only_deleted);
        }

        $this->_set_where($where);

        $this->trigger('before_get');

        $row = $this->_database->get($this->_table)
                        ->{$this->_return_type()}();

        $this->_temporary_return_type = $this->return_type;

        $row = $this->trigger('after_get', $row);

        $this->_with = [];

        return $row;
    }

    /**
     * Fetch an array of records based on an array of primary values.
     */
    public function get_many($values)
    {
        $this->_database->where_in($this->primary_key, $values);

        return $this->get_all();
    }

    /**
     * Fetch an array of records based on an arbitrary WHERE call.
     */
    public function get_many_by()
    {
        $where = func_get_args();

        $this->_set_where($where);

        return $this->get_all();
    }

    /**
     * Fetch all the records in the table. Can be used as a generic call
     * to $this->_database->get() with scoped methods.
     */
    public function get_all()
    {
        $this->trigger('before_get');

        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE) {
            $this->_database->where($this->soft_delete_key, (bool) $this->_temporary_only_deleted);
        }

        $result = $this->_database->get($this->_table)->{$this->_return_type(1)}();

        $this->_temporary_return_type = $this->return_type;

        foreach ($result as $key => &$row) {
            $row = $this->trigger('after_get', $row, ($key === count($result) - 1));
        }

        $this->_with = [];

        return $result;
    }

    /**
     * Set the fillable attributes for the model.
     *
     * @param  array $fillable
     * @return this
     */
    public function fillable(array $fillable)
    {
        $this->fillable = $fillable;

        return $this;
    }

    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Get the fillable attributes of a given array.
     *
     * @param  array $attributes
     * @return array
     */
    protected function fillableFromArray(array $attributes)
    {
        if (count($this->fillable) > 0) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }

        return $attributes;
    }

    /**
     * Insert a new row into the table. $data should be an associative array
     * of data to be inserted. Returns newly created ID.
     */
    public function create($data, $skip_validation = false)
    {
        if ($skip_validation === FALSE) {
            $data = $this->validate($data);
        }

        if ($data !== FALSE) {
            // table field filter
            $data = $this->fillableFromArray($data);

            if ($this->timestamps) {
                $this->before_create = array_unique(array_merge($this->before_create,
                                        ['created_at', 'updated_at']));
            }

            $data = $this->trigger('before_create', $data);

            $this->_database->insert($this->_table, $data);
            $insert_id = $this->_database->insert_id();

            $this->trigger('after_create', array_merge([$this->primary_key => $insert_id], $data));

            return $insert_id;
        } else {
            return FALSE;
        }
    }

    /**
     * Insert multiple rows into the table. Returns an array of multiple IDs.
     */
    public function insert_many($data, $skip_validation = false)
    {
        $ids = [];

        foreach ($data as $key => $row) {
            $ids[] = $this->create($row, $skip_validation, ($key === count($data) - 1));
        }

        return $ids;
    }

    /**
     * Increase count.
     */
    public function increase($primary_value, $data)
    {
        $primary_value = (int) $primary_value;
        $data = (array) $data;

        if (empty($primary_value) or empty($data)) {
            return false;
        }

        foreach ($data as $row) {
            $this->_database->set($row, $row . ' + 1', false);
        }

        $result = $this->_database
            ->where($this->primary_key, $primary_value)
            ->update($this->_table);

        return $result;
    }

    /**
     * Decrease count.
     */
    public function decrease($primary_value, $data)
    {
        $primary_value = (int) $primary_value;
        $data = (array) $data;

        if (empty($primary_value) or empty($data)) {
            return false;
        }

        foreach ($data as $row) {
            $this->_database->set($row, $row . ' - 1', false);
        }

        $result = $this->_database
            ->where($this->primary_key, $primary_value)
            ->update($this->_table);

        return $result;
    }

    /**
     * Updated a record based on the primary value.
     */
    public function update($primary_value, $data, $skip_validation = false)
    {
        if ($skip_validation === FALSE) {
            $data = $this->validate($data);
        }

        if ($data !== FALSE) {
            // table field filter
            $data = $this->fillableFromArray($data);

            if ($this->timestamps) {
                $this->before_update = array_unique(array_merge($this->before_update,
                                        ['updated_at']));
            }

            $data = $this->trigger('before_update', $data);

            $result = $this->_database->where($this->primary_key, $primary_value)
                               ->set($data)
                               ->update($this->_table);

            $this->trigger('after_update', [array_merge([$this->primary_key => $primary_value], $data), $result]);

            return $result;
        } else {
            return FALSE;
        }
    }

    /**
     * Update many records, based on an array of primary values.
     */
    public function update_many($primary_values, $data, $skip_validation = false)
    {
        // table field filter
        $data = $this->fillableFromArray($data);

        if ($this->timestamps) {
            $this->before_update = array_unique(array_merge($this->before_update,
                                    ['updated_at']));
        }

        $data = $this->trigger('before_update', $data);

        if ($skip_validation === FALSE) {
            $data = $this->validate($data);
        }

        if ($data !== FALSE) {
            $result = $this->_database->where_in($this->primary_key, $primary_values)
                               ->set($data)
                               ->update($this->_table);

            $this->trigger('after_update', [$data, $result]);

            return $result;
        } else {
            return FALSE;
        }
    }

    /**
     * Updated a record based on an arbitrary WHERE clause.
     */
    public function update_by()
    {
        $args = func_get_args();
        $data = array_pop($args);

        // table field filter
        $data = $this->fillableFromArray($data);

        if ($this->timestamps) {
            $this->before_update = array_unique(array_merge($this->before_update,
                                    ['updated_at']));
        }

        $data = $this->trigger('before_update', $data);

        if ($this->validate($data) !== FALSE) {
            $this->_set_where($args);
            $result = $this->_database->set($data)
                               ->update($this->_table);
            $this->trigger('after_update', [$data, $result]);

            return $result;
        } else {
            return FALSE;
        }
    }

    /**
     * Update all records
     */
    public function update_all($data)
    {
        // table field filter
        $data = $this->fillableFromArray($data);

        if ($this->timestamps) {
            $this->before_update = array_unique(array_merge($this->before_update,
                                    ['updated_at']));
        }

        $data = $this->trigger('before_update', $data);

        $result = $this->_database->set($data)
                           ->update($this->_table);
        $this->trigger('after_update', [$data, $result]);

        return $result;
    }

    /**
     * Delete a row from the table by the primary value
     */
    public function delete($id)
    {
        $this->trigger('before_delete', $id);

        $this->_database->where($this->primary_key, $id);

        if ($this->soft_delete) {
            $result = $this->_database->update($this->_table, [ $this->soft_delete_key => TRUE ]);
        } else {
            $result = $this->_database->delete($this->_table);
        }

        $this->trigger('after_delete', [[$this->primary_key => $id], $result]);

        return $result;
    }

    /**
     * Delete a row from the database table by an arbitrary WHERE clause
     */
    public function delete_by()
    {
        $where = func_get_args();

        $where = $this->trigger('before_delete', $where);

        $this->_set_where($where);

        if ($this->soft_delete) {
            $result = $this->_database->update($this->_table, [ $this->soft_delete_key => TRUE ]);
        } else {
            $result = $this->_database->delete($this->_table);
        }

        $this->trigger('after_delete', $result);

        return $result;
    }

    /**
     * Delete many rows from the database table by multiple primary values
     */
    public function delete_many($primary_values)
    {
        $primary_values = $this->trigger('before_delete', $primary_values);

        $this->_database->where_in($this->primary_key, $primary_values);

        if ($this->soft_delete) {
            $result = $this->_database->update($this->_table, [ $this->soft_delete_key => TRUE ]);
        } else {
            $result = $this->_database->delete($this->_table);
        }

        $this->trigger('after_delete', [[$this->primary_key => $primary_values], $result]);

        return $result;
    }

    /**
     * Truncates the table
     */
    public function truncate()
    {
        $result = $this->_database->truncate($this->_table);

        return $result;
    }

    /* --------------------------------------------------------------
     * RELATIONSHIPS
     * ------------------------------------------------------------ */

    public function with($relationship)
    {
        $this->_with[] = $relationship;

        if (!in_array('relate', $this->after_get, true)) {
            $this->after_get[] = 'relate';
        }

        return $this;
    }

    public function relate($row)
    {
        if (empty($row)) {
            return $row;
        }

        foreach ($this->belongs_to as $key => $value) {
            if (is_string($value)) {
                $relationship = $value;
                $options = [ 'primary_key' => $value . '_id', 'model' => $value . '_model' ];
            } else {
                $relationship = $key;
                $options = $value;
            }

            if (in_array($relationship, $this->_with, true)) {
                $this->load->model($options['model'], $relationship . '_model');

                if (is_object($row)) {
                    $row->{$relationship} = $this->{$relationship . '_model'}->get($row->{$options['primary_key']});
                } else {
                    $row[$relationship] = $this->{$relationship . '_model'}->get($row[$options['primary_key']]);
                }
            }
        }

        foreach ($this->has_many as $key => $value) {
            if (is_string($value)) {
                $relationship = $value;
                $options = [ 'primary_key' => singular($this->_table) . '_id', 'model' => singular($value) . '_model' ];
            } else {
                $relationship = $key;
                $options = $value;
            }

            if (in_array($relationship, $this->_with, true)) {
                $this->load->model($options['model'], $relationship . '_model');

                if (is_object($row)) {
                    $row->{$relationship} = $this->{$relationship . '_model'}->get_many_by($options['primary_key'], $row->{$this->primary_key});
                } else {
                    $row[$relationship] = $this->{$relationship . '_model'}->get_many_by($options['primary_key'], $row[$this->primary_key]);
                }
            }
        }

        return $row;
    }

    /* --------------------------------------------------------------
     * UTILITY METHODS
     * ------------------------------------------------------------ */

    /**
     * Retrieve and generate a form_dropdown friendly array
     */
    public function dropdown()
    {
        $args = func_get_args();

        if (count($args) === 2) {
            list($key, $value) = $args;
        } else {
            $key = $this->primary_key;
            $value = $args[0];
        }

        $this->trigger('before_dropdown', [ $key, $value ]);

        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE) {
            $this->_database->where($this->soft_delete_key, false);
        }

        $result = $this->_database->select([$key, $value])
                           ->get($this->_table)
                           ->result();

        $options = [];

        foreach ($result as $row) {
            $options[$row->{$key}] = $row->{$value};
        }

        $options = $this->trigger('after_dropdown', $options);

        return $options;
    }

    /**
     * Fetch a count of rows based on an arbitrary WHERE call.
     */
    public function count_by()
    {
        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE) {
            $this->_database->where($this->soft_delete_key, (bool) $this->_temporary_only_deleted);
        }

        $where = func_get_args();
        $this->_set_where($where);

        return $this->_database->count_all_results($this->_table);
    }

    /**
     * Fetch a total count of rows, disregarding any previous conditions
     */
    public function count_all()
    {
        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE) {
            $this->_database->where($this->soft_delete_key, (bool) $this->_temporary_only_deleted);
        }

        return $this->_database->count_all($this->_table);
    }

    /**
     * Tell the class to skip the insert validation
     */
    public function skip_validation()
    {
        $this->skip_validation = true;

        return $this;
    }

    /**
     * Get the skip validation status
     */
    public function get_skip_validation()
    {
        return $this->skip_validation;
    }

    /**
     * Return the next auto increment of the table. Only tested on MySQL.
     */
    public function get_next_id()
    {
        return (int) $this->_database->select('AUTO_INCREMENT')
            ->from('information_schema.TABLES')
            ->where('TABLE_NAME', $this->_table)
            ->where('TABLE_SCHEMA', $this->_database->database)->get()->row()->AUTO_INCREMENT;
    }

    /**
     * Getter for the table name
     */
    public function table()
    {
        return $this->_table;
    }

    /* --------------------------------------------------------------
     * GLOBAL SCOPES
     * ------------------------------------------------------------ */

    /**
     * Return the next call as an array rather than an object
     */
    public function as_array()
    {
        $this->_temporary_return_type = 'array';

        return $this;
    }

    /**
     * Return the next call as an object rather than an array
     */
    public function as_object()
    {
        $this->_temporary_return_type = 'object';

        return $this;
    }

    /**
     * Don't care about soft deleted rows on the next call
     */
    public function with_deleted()
    {
        $this->_temporary_with_deleted = true;

        return $this;
    }

    /**
     * Only get deleted rows on the next call
     */
    public function only_deleted()
    {
        $this->_temporary_only_deleted = true;

        return $this;
    }

    /* --------------------------------------------------------------
     * OBSERVERS
     * ------------------------------------------------------------ */

    /**
     * Get a fresh timestamp for the model.
     *
     * @return date
     */
    public function freshTimestamp()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * MySQL DATETIME created_at and updated_at
     */
    public function created_at($row)
    {
        $time = $this->freshTimestamp();

        if (is_object($row)) {
            $row->{static::CREATED_AT} = $time;
        } else {
            $row[static::CREATED_AT] = $time;
        }

        return $row;
    }

    public function updated_at($row)
    {
        $time = $this->freshTimestamp();

        if (is_object($row)) {
            $row->{static::UPDATED_AT} = $time;
        } else {
            $row[static::UPDATED_AT] = $time;
        }

        return $row;
    }

    /**
     * Serialises data for you automatically, allowing you to pass
     * through objects and let it handle the serialisation in the background
     */
    public function serialize($row)
    {
        foreach ($this->callback_parameters as $column) {
            $row[$column] = serialize($row[$column]);
        }

        return $row;
    }

    public function unserialize($row)
    {
        foreach ($this->callback_parameters as $column) {
            if (is_array($row)) {
                $row[$column] = unserialize($row[$column]);
            } else {
                $row->$column = unserialize($row->$column);
            }
        }

        return $row;
    }

    /**
     * Protect attributes by removing them from $row array
     */
    public function protect_attributes($row)
    {
        foreach ($this->protected_attributes as $attr) {
            if (is_object($row)) {
                unset($row->$attr);
            } else {
                unset($row[$attr]);
            }
        }

        return $row;
    }

    /* --------------------------------------------------------------
     * QUERY BUILDER DIRECT ACCESS METHODS
     * ------------------------------------------------------------ */

    /**
     * A wrapper to $this->_database->order_by()
     */
    public function order_by($criteria, $order = 'ASC')
    {
        if (is_array($criteria)) {
            foreach ($criteria as $key => $value) {
                $this->_database->order_by($key, $value);
            }
        } else {
            $this->_database->order_by($criteria, $order);
        }

        return $this;
    }

    /**
     * A wrapper to $this->_database->limit()
     */
    public function limit($limit = null, $offset = 0)
    {
        $limit = (int) $limit;
        if ($limit) {
            $this->_database->limit($limit, $offset);
        }

        return $this;
    }

    /* --------------------------------------------------------------
     * INTERNAL METHODS
     * ------------------------------------------------------------ */

    /**
     * Trigger an event and call its observers. Pass through the event name
     * (which looks for an instance variable $this->event_name), an array of
     * parameters to pass through and an optional 'last in interation' boolean
     */
    public function trigger($event, $data = false, $last = true)
    {
        if (isset($this->$event) && is_array($this->$event)) {
            foreach ($this->$event as $method) {
                if (strpos($method, '(')) {
                    preg_match('/([a-zA-Z0-9\_\-]+)(\(([a-zA-Z0-9\_\-\., ]+)\))?/', $method, $matches);

                    $method = $matches[1];
                    $this->callback_parameters = explode(',', $matches[3]);
                }

                $data = call_user_func_array([$this, $method], [$data, $last]);
            }
        }

        return $data;
    }

    /**
     * Run validation on the passed data
     */
    public function validate($data)
    {
        if ($this->skip_validation) {
            return $data;
        }

        if (!empty($this->validate)) {
            foreach ($data as $key => $val) {
                $_POST[$key] = $val;
            }

            $this->load->library('form_validation');

            if (is_array($this->validate)) {
                $this->form_validation->set_rules($this->validate);

                if ($this->form_validation->run() === TRUE) {
                    return $data;
                } else {
                    return FALSE;
                }
            } else {
                if ($this->form_validation->run($this->validate) === TRUE) {
                    return $data;
                } else {
                    return FALSE;
                }
            }
        } else {
            return $data;
        }
    }

    /**
     * Determine if the model uses timestamps.
     *
     * @return bool
     */
    public function usesTimestamps()
    {
        return $this->timestamps;
    }

    /**
     * Get the name of the "created at" column.
     *
     * @return string
     */
    public function getCreatedAtColumn()
    {
        return static::CREATED_AT;
    }

    /**
     * Get the name of the "updated at" column.
     *
     * @return string
     */
    public function getUpdatedAtColumn()
    {
        return static::UPDATED_AT;
    }

    /**
     * Guess the table name by pluralising the model name
     */
    private function _fetch_table()
    {
        if ($this->_table === NULL) {
            $this->_table = plural(preg_replace('/(_m|_model)?$/', '', strtolower(get_class($this))));
        }
    }

    /**
     * Guess the primary key for current table
     */
    private function _fetch_primary_key()
    {
        if ($this->primary_key === NULl) {
            $this->primary_key = $this->_database->query("SHOW KEYS FROM `" . $this->_table . "` WHERE Key_name = 'PRIMARY'")->row()->Column_name;
        }
    }

    /**
     * Set WHERE parameters, cleverly
     */
    protected function _set_where($params)
    {
        if (count($params) === 1 && is_array($params[0])) {
            foreach ($params[0] as $field => $filter) {
                if (is_array($filter)) {
                    $this->_database->where_in($field, $filter);
                } else {
                    if (is_int($field)) {
                        $this->_database->where($filter);
                    } else {
                        $this->_database->where($field, $filter);
                    }
                }
            }
        } elseif (count($params) === 1) {
            $this->_database->where($params[0]);
        } elseif (count($params) === 2) {
            if (is_array($params[1])) {
                $this->_database->where_in($params[0], $params[1]);
            } else {
                $this->_database->where($params[0], $params[1]);
            }
        } elseif (count($params) === 3) {
            $this->_database->where($params[0], $params[1], $params[2]);
        } else {
            if (is_array($params[1])) {
                $this->_database->where_in($params[0], $params[1]);
            } else {
                $this->_database->where($params[0], $params[1]);
            }
        }
    }

    /**
     * Return the method name for the current return type
     */
    protected function _return_type($multi = false)
    {
        $method = ($multi) ? 'result' : 'row';

        return $this->_temporary_return_type === 'array' ? $method . '_array' : $method;
    }
}


/* End of file MY_Model.php */
/* Location: .//opt/lampp/htdocs/project/app/core/MY_Model.php */