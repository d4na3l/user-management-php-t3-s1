<?php
// Trait model, básicamente qué consultas podrán hacer, por ahora, los diferentes modelos a la base de datos.
namespace core;

trait Model
{
    use Database;

    protected $order = 'created_at';

    // Lee y retorna todos los datos de la base de datos de la tabla correspondiente en orden de id.
    function read()
    {
        $query = 'SELECT * FROM  "' . $this->table . '" ORDER BY "' . $this->order . '"';
        return $this->query($query);
    }

    // Extrae las coincidencias.
    public function where($data, $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = 'SELECT * FROM "' . $this->table . '" WHERE ';

        foreach ($keys as $key) {
            $query .= $key . ' = :' . $key . ' AND ';
        };
        foreach ($keys_not as $key) {
            $query .= $key . ' != :' . $key . ' AND ';
        };

        $query = trim($query, ' AND ');
        $data = array_merge($data, $data_not);
        return $this->query($query, $data);
    }

    // Extrae la primera de las coincidencias.
    public function first($data, $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = 'SELECT * FROM "' . $this->table . '" WHERE ';

        foreach ($keys as $key) {
            $query .= $key . ' = :' . $key . ' AND ';
        };
        foreach ($keys_not as $key) {
            $query .= $key . ' != :' . $key . ' AND ';
        };

        $query = trim($query, ' AND ');

        $data = array_merge($data, $data_not);

        $result = $this->query($query, $data);
        if ($result)
            return $result[0];
        return false;
    }

    // Inserta datos dentro de la base de datos
    public function insert($data)
    {
        // Verificamos que sean datos que se pueden manipular
        if (!empty($this->fillable)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->fillable)) {
                    unset($data[$key]);
                }
            }
            if (empty($data)) {
                return false;
            }
        }
        $keys = array_keys($data);

        $query = 'INSERT INTO "' . $this->table . '" (' . implode(',', $keys) . ') VALUES (:' . implode(',:', $keys) . ')';
        $this->query($query, $data);
        return false;
    }

    // Actualiza datos dentro de la base de datos
    public function update($id, $data)
    {
        $id_column = $this->id;
        // Verificamos que sean datos que se pueden manipular
        if (!empty($this->fillable)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->fillable)) {
                    unset($data[$key]);
                }
            }
            if (empty($data)) {
                return false;
            }
        }

        $keys = array_keys($data);
        $query = 'UPDATE "' . $this->table . '" SET ';

        foreach ($keys as $key) {
            $query .= $key . ' = :' . $key . ', ';
        };

        $query = trim($query, ', ');
        $query .= ' WHERE ' . $id_column . ' = :' . $id_column;

        $data[$id_column] = $id;
        $this->query($query, $data);
        return false;
    }
}
