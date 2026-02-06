<?php

namespace Repositories;

use PDO;

class GoodsRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Get all roles
     * @return array
     */
    public function getAll(): array
    {
        return $this->db->query("SELECT * FROM goods ORDER BY id ASC")->fetchAll() ?? [];
    }

    /**
     * Get goods with additional fields.
     *
     * @return array
     */
    public function getGoodsReport(): array
    {
        $sql = "SELECT 
                g.name AS product_name,
                af1.name AS f_name1, afv1.name AS f_val1,
                af2.name AS f_name2, afv2.name AS f_val2
            FROM goods g
            LEFT JOIN additional_goods_field_values agfv1 ON g.id = agfv1.good_id AND agfv1.additional_field_id = 1
            LEFT JOIN additional_fields af1 ON agfv1.additional_field_id = af1.id
            LEFT JOIN additional_field_values afv1 ON agfv1.additional_field_value_id = afv1.id
            LEFT JOIN additional_goods_field_values agfv2 ON g.id = agfv2.good_id AND agfv2.additional_field_id = 2
            LEFT JOIN additional_fields af2 ON agfv2.additional_field_id = af2.id
            LEFT JOIN additional_field_values afv2 ON agfv2.additional_field_value_id = afv2.id";

        $items = $this->db->query($sql)->fetchAll();

        return array_map(function ($item) {
            return [
                'name'   => $item['product_name'],
                'field1' => ($item['f_name1'] ?? 'Field 1') . ': ' . ($item['f_val1'] ?? '-'),
                'field2' => ($item['f_name2'] ?? 'Field 2') . ': ' . ($item['f_val2'] ?? '-'),
            ];
        }, $items);
    }
}
