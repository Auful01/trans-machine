<?php

namespace App\Helpers;


class CheckType
{

    public static function accFiles($data)
    {
        $type_pars = [
            [
                'id' => 'pdf',
                'val' => '.pdf'
            ],
            [
                'id' => 'excel',
                'val' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel',
            ],
            [
                'id'  => 'img',
                'val' => 'image/*'
            ]
        ];

        $acc_pars = '';
        if (str_contains($data, ',')) {
            $acc = explode(',', $data->accept);
            # code...


            foreach ($acc as $key => $val) {
                if ($data = array_search($val, array_column($type_pars, 'id'))) {
                    # code...
                    $acc_pars .= $type_pars[$data]['val'] . ', ';
                }
            }

            return $acc_pars;
        } else {
            if ($acc_par = array_search($data, array_column($type_pars, 'id'))) {
                # code...
                $acc_pars .= $type_pars[$acc_par]['val'];
            }
            return $acc_pars;
        }
    }
}
